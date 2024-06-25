<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnShareThrive</title>
    <link rel="stylesheet" href="styles.css"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="Logo-art-white.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Chivo:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <style>
        /* Add your custom CSS styles here */
        .error-message {
            color: red;
            margin-top: 5px;
            text-align: center;
            font-size: 14px;
        }
        .form-message {
            color: green;
            margin-top: 5px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php session_start(); ?>
        <nav> 
            <img src="Images/LOGO.png" class="Logo">
            <ul>
                <li><a href="#">About us</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <div class="content">
            <div class="header">
                <h1>Empowering Students to Learn, Share, and Thrive!</h1>
                <h2>Your Ultimate Hub for Collaborative Learning and Course Sharing</h2>
                <br> 
            </div>
            <div class="wrapper">
                <form id="registerForm" action="register_b.php" method="POST" onsubmit="return validateForm()">
                    <h1>Register</h1>
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" placeholder="Email" required>
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <div class="error-message" id="passwordError"></div>
                    <div class="input-box">
                        <input type="date" name="birthday" placeholder="Birthday" required>
                        <i class='bx bxs-calendar'></i>
                    </div>
                    <button type="submit" name="register" class="btn">Register</button>
                    <div class="login-link">
                        Already a member? <a href="index.php">Sign In</a>
                    </div>
                    <div class="form-message" id="formMessage">
                        <?php
                        // Check if there's a message to display from PHP
                        if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']); // Clear the message once displayed
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="services-section" id="services-section">
        <div class="title">
             <img src="Images/stars-svgrepo-com.png" class="stars1" style="filter: invert(100%) sepia(93%) saturate(29%) hue-rotate(124deg) brightness(107%) contrast(110%);">
             <h1>Creative Learning Made Easy</h1>
             <img src="Images/stars-svgrepo-com.png" class="stars2" style="filter: invert(100%) sepia(93%) saturate(29%) hue-rotate(124deg) brightness(107%) contrast(110%);">
        </div>
        <div class="services">
        <div class="card">
               <img src="Images/instructor.png" class="s-icons" style="filter: invert(100%) sepia(93%) saturate(29%) hue-rotate(124deg) brightness(107%) contrast(110%);">
               <h1>Knowledge Sharing</h1>
               <h2>Share your knowledge and teach courses on subjects you love.</h2>
        </div>
        <div class="card">
               <img src="Images/collaboration.png" class="s-icons" style="filter: invert(100%) sepia(93%) saturate(29%) hue-rotate(124deg) brightness(107%) contrast(110%);">
               <h1>Collaborative Learning</h1>
               <h2>Learn and grow with fellow students from around the world.</h2>
        </div>
        <div class="card">
               <img src="Images/online-library.png" class="s-icons" style="filter: invert(100%) sepia(93%) saturate(29%) hue-rotate(124deg) brightness(107%) contrast(110%);">
               <h1>Diverse Subjects</h1>
               <h2>Explore thousands of courses across various subjects, from beginner to advanced levels.</h2>
        </div>
        </div>
    </div>
</div>
<script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var passwordError = document.getElementById("passwordError");
        
        passwordError.innerHTML = "";

        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z]).{7,}$/;

        if (!passwordRegex.test(password)) {
            passwordError.innerHTML = "Password must be at least 7 characters long and include at least one uppercase letter and one lowercase letter.";
            return false;
        }

        return true;
    }
</script>
</body>
</html>
