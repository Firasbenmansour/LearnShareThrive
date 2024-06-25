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

// Function to generate star rating HTML
function getStarRating($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        $stars .= '<span class="star' . ($i <= $rating ? ' filled' : '') . '">★</span>';
    }
    return $stars;
}

// Pagination variables
$reviewsPerPage = 3;
$totalReviews = count($courseReviews);
$totalPages = ceil($totalReviews / $reviewsPerPage);
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startIndex = ($currentPage - 1) * $reviewsPerPage;
$paginatedReviews = array_slice($courseReviews, $startIndex, $reviewsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews for <?php echo htmlspecialchars($course); ?></title>
    <link rel="stylesheet" href="review.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Chivo:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;  
            padding: 0;
            font-family: "Chivo", sans-serif;
            box-sizing: border-box;
        }
        .star {
            font-size: 30px;
            color: #000000bd;
        }
        .star.filled {
            color: #ffffff;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin: 10px 0;
            
        }
        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            text-decoration: none;
            color: #000;
            border: 1px solid #000;
        }
        .pagination a.active {
            background-color: #000;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <a href="home.php"><img src="Images/LOGO.png" alt="Logo" class="logo"></a>
        <ul class="menu">
            <li><a href="#">ABOUT US</a></li>
            <li><a href="submit.html">UPLOAD</a></li>
            <li><a href="contact.html">CONTACT</a></li>
        </ul>
        <div class="user-dropdown">
            <button class="user-btn">
                <img src="Images/user.png" alt="User" class="user" style="filter: invert(100%) sepia(93%) saturate(29%) hue-rotate(124deg) brightness(107%) contrast(110%);">
            </button>
            <div class="dropdown-content">
                <a href="account.php">Check Account</a>
                <a href="logout.php">logout</a>
            </div>
        </div>
    </div>
    <div class="page2">
        
        <div class="review-container">
        <h1>Reviews for <?php echo htmlspecialchars($course); ?></h1>
            <div class="existing-reviews">
                <?php if (empty($courseReviews)): ?>
                    <p>No reviews yet. Be the first to review this course!</p>
                <?php else: ?>
                    <?php foreach ($paginatedReviews as $review): ?>
                        <div class="review">
                            <p id="user"><b><?php echo htmlspecialchars($review[0]); ?><b></p>
                            <p><?php echo getStarRating($review[4]); ?></p>
                            <p><?php echo htmlspecialchars($review[3]); ?></p>
                            <p><small>On: <?php echo htmlspecialchars($review[2]) . ', ' . htmlspecialchars($review[1]); ?></small></p>
                            <p><small><?php echo htmlspecialchars($review[5]); ?></small></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?course=<?php echo urlencode($course); ?>&category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>" class="<?php echo $i == $currentPage ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
            <div class="new-review">
                <h2>Submit a Review</h2>
                <form action="reviews.php?course=<?php echo htmlspecialchars($course); ?>&category=<?php echo htmlspecialchars($category); ?>" method="post">
                    <!-- Dynamically set the subject based on the course and category -->
                    <input type="hidden" name="subject" value="<?php echo htmlspecialchars($category); ?>">
                    <div class="rating-container">
                        <div class="rating">
                            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="text"></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="text"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="text"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="text"></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="text"></label>
                        </div>
                    </div>
                    <textarea name="review" id="review" rows="4" placeholder="Review" required></textarea>
                    <button type="submit">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
