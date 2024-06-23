<?php
session_start();
$course = isset($_GET['course']) ? $_GET['course'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : ''; // Retrieve category from URL

// Path to the reviews file
$reviewsFile = __DIR__ . '/data/reviews.csv';

// Check if the reviews file exists; if not, create it
if (!file_exists($reviewsFile)) {
    $file = fopen($reviewsFile, 'w');
    // Add headers if needed
    fputcsv($file, ['user', 'subject', 'course-title', 'review', 'stars', 'date']);
    fclose($file);
}

// Load existing reviews
$reviews = [];
if (($file = fopen($reviewsFile, 'r')) !== FALSE) {
    while (($data = fgetcsv($file)) !== FALSE) {
        $reviews[] = $data;
    }
    fclose($file);
}

// Handle new review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : 'Anonymous';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : 'General'; // Adjust as necessary
    $rating = $_POST['rating'];
    $reviewText = $_POST['review'];
    $date = date('Y-m-d H:i:s');

    $newReview = [$user, $subject, $course, $reviewText, $rating, $date];

    // Append the new review to the CSV file
    if (($file = fopen($reviewsFile, 'a')) !== FALSE) {
        fputcsv($file, $newReview);
        fclose($file);
    }

    // Redirect to the same page to avoid form resubmission
    header("Location: reviews.php?course=" . urlencode($course) . "&category=" . urlencode($category));
    exit();
}

// Filter reviews for the current course and category
$courseReviews = array_filter($reviews, function($review) use ($course, $category) {
    return $review[2] === $course && $review[1] === $category; // Index 2 is course-title, Index 1 is category
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews for <?php echo htmlspecialchars($course); ?></title>
    <link rel="stylesheet" href="reviews.css">
</head>
<body>
    <div class="review-container">
        <h1>Reviews for <?php echo htmlspecialchars($course); ?></h1>
        <div class="existing-reviews">
            <h2>Reviews</h2>
            <?php if (empty($courseReviews)): ?>
                <p>No reviews yet. Be the first to review this course!</p>
            <?php else: ?>
                <?php foreach ($courseReviews as $review): ?>
                    <div class="review">
                        <p>User: <?php echo htmlspecialchars($review[0]); ?></p>
                        <p>Rating: <?php echo htmlspecialchars($review[4]); ?>/5</p>
                        <p>on: <?php echo htmlspecialchars($review[2]) . ', ' . htmlspecialchars($review[1]); ?></p>
                        <p><?php echo htmlspecialchars($review[3]);?></p>
                        <p><small><?php echo htmlspecialchars($review[5]); ?></small></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="new-review">
            <h2>Submit a Review</h2>
            <form action="reviews.php?course=<?php echo htmlspecialchars($course); ?>&category=<?php echo htmlspecialchars($category); ?>" method="post">
                <!-- Dynamically set the subject based on the course and category -->
                <input type="hidden" name="subject" value="<?php echo htmlspecialchars($category); ?>">
                <label for="rating">Rating (1-5):</label>
                <select name="rating" id="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <label for="review">Review:</label>
                <textarea name="review" id="review" rows="4" required></textarea>
                <button type="submit">Submit Review</button>
            </form>
        </div>
    </div>
</body>
</html>
