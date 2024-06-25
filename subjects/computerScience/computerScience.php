<?php
$Directory = "."; // Directory where Computer Science.php is located
$Category = "Computer Science"; // Set the category explicitly
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Science Courses</title>
    <link rel="stylesheet" href="/learnsharethrive/subjects/subjects.css"> <!-- Link to your subjects.css file -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Chivo:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="page">
        <div class="header">
            <a href="/learnsharethrive/home.php"><img src="/learnsharethrive/Images/LOGO.png" alt="Logo" class="logo"></a>
            <ul class="menu">
                <li><a href="#">ABOUT US</a></li>
                <li><a href="/learnsharethrive/submit.html">UPLOAD</a></li>
                <li><a href="/learnsharethrive/contact.html">CONTACT</a></li>
            </ul>
            <div class="user-dropdown">
                <button class="user-btn">
                    <img src="/learnsharethrive/Images/user.png" alt="User" class="user" style="filter: invert(100%) sepia(93%) saturate(29%) hue-rotate(124deg) brightness(107%) contrast(110%);">
                </button>
                <div class="dropdown-content">
                    <a href="/learnsharethrive/account.php">Check Account</a>
                    <a href="/learnsharethrive/logout.php">logout</a>
                </div>
            </div>
        </div>

        <div class="wrapper">
            <h1>Computer Science Courses</h1>
            <div class="card-container">
                <?php
                // Check if the Computer Science directory exists
                if (is_dir($Directory)) {
                    // Open the Computer Science directory
                    $courseFolders = scandir($Directory);

                    foreach ($courseFolders as $folder) {
                        // Skip the current and parent directory entries and the Computer Science.php file
                        if ($folder === '.' || $folder === '..' || $folder === 'Computer Science.php') {
                            continue;
                        }

                        // Full path to the course folder
                        $coursePath = $Directory . '/' . $folder . '/';

                        // Check if the path is a directory
                        if (is_dir($coursePath)) {
                            // Read course info
                            $infoFile = $coursePath . 'info.txt';

                            if (file_exists($infoFile)) {
                                $infoContent = file_get_contents($infoFile);
                                $infoLines = explode("\n", $infoContent);
                                $title = str_replace('Title: ', '', $infoLines[0]);
                                $description = str_replace('Description: ', '', $infoLines[1]);

                                // Find the uploaded file
                                $files = array_diff(scandir($coursePath), array('.', '..', 'info.txt'));
                                $fileLink = '';
                                foreach ($files as $file) {
                                    if (is_file($coursePath . $file)) {
                                        $fileLink = $coursePath . $file;
                                        break;
                                    }
                                }
                                ?>

                                <div class="card">
                                    <div class="card-content">
                                        <h1><?php echo htmlspecialchars($title); ?></h1>
                                        <p><?php echo nl2br(htmlspecialchars($description)); ?></p>

                                        <?php if ($fileLink): ?>
                                            <a href="<?php echo htmlspecialchars($fileLink); ?>" class="btn">Download</a>
                                        <?php endif; ?>
                                        
                                        <a href="/learnsharethrive/reviews.php?course=<?php echo urlencode($title); ?>&category=<?php echo urlencode($Category); ?>" class="btn">Reviews</a>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                    }
                } else {
                    echo "<p>No courses found in the Computer Science directory.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
