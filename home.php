<?php
session_start();

if (!isset($_SESSION['user'])) {
    // If the user is not logged in, redirect to the register page
    header("Location: register.php");
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Chivo:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    
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
        <div class="card-container">
            <div class="card">
                <img class="fond" src="Images/MATH.png" alt="Mathematics">
                <div class="card-content">
                    <h3>Mathematics</h3>
                    <p>Explore the world of numbers, equations, and algorithms. Whether you're tackling algebra or calculus, we have the resources to help you succeed.</p>
                    <a href="subjects/math/math.php" class="btn">Start learning</a>
                </div>
            </div>
            <div class="card">
                <img class="fond" src="Images/PHYSICS.png" alt="Physics">
                <div class="card-content">
                    <h3>Physics</h3>
                    <p>Dive into the laws of nature and understand the forces that govern the universe. From classical mechanics to quantum physics, let's explore together.</p>
                    <a href="subjects/physics/physics.php" class="btn">Start learning</a>
                </div>
            </div>
            <div class="card">
                <img class="fond" src="Images/ENGLISH.png" alt="English">
                <div class="card-content">
                    <h3>English</h3>
                    <p>Enhance your language skills with our comprehensive English courses. Improve your grammar, expand your vocabulary, and master the art of writing.</p>
                    <a href="subjects/english/english.php" class="btn">Start learning</a>
                </div>
            </div>
            <div class="card">
                <img class="fond" src="Images/PHYLOSOPHY.png" alt="Philosophy">
                <div class="card-content">
                    <h3>Philosophy</h3>
                    <p>Embark on a journey of intellectual discovery. Delve into the thoughts of great philosophers and tackle the big questions about existence and morality.</p>
                    <a href="subjects/philosophy/philosophy.php" class="btn">Start learning</a>
                </div>
            </div>
            <div class="card">
                <img class="fond" src="Images/BIOLOGY.png" alt="Biology">
                <div class="card-content">
                    <h3>Biology</h3>
                    <p>Uncover the mysteries of life through our biology courses. Study the complexities of ecosystems, genetics, and the inner workings of living organisms.</p>
                    <a href="subjects/biology/biology.php" class="btn">Start learning</a>
                </div>
            </div>
            <div class="card">
                <img class="fond" src="Images/COMPUTER SCIENCE.png" alt="Computer Science">
                <div class="card-content">
                    <h3>Computer Science</h3>
                    <p>Step into the world of computing and technology. Learn programming languages, software development, and the principles of artificial intelligence.</p>
                    <a href="subjects/computerScience/computerScience.php" class="btn">Start learning</a>
                </div>
            </div>
        </div>        
    </div>
    
</body>
</html>
