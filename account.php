<?php
// Start PHP session
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redirect to login page if user is not logged in
    header("Location: index.html");
    exit();
}

// Initialize variables
$username = '';
$email = '';
$birthday = '';

// Open CSV file for user data
$users_file = fopen("data/users.csv", "r");

// Get logged-in user's ID
$self_id = $_SESSION['id'];

// Find user's information
while (($ligne = fgetcsv($users_file)) !== false) {
    if ($ligne[0] == $self_id) {
        // Assign user information to variables
        $username = $ligne[1];
        $email = $ligne[2];
        $birthday = $ligne[3];
        break;
    }
}

// Close CSV file
fclose($users_file);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account</title>
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "poppins", sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-image: linear-gradient(to bottom, rgba(21, 144, 158, 0.096), rgba(0, 0, 0, 0.774)), url(Images/Background-fadded.png);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
}

.container {
    width: 550px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 30px;
    padding: 50px 40px;
    box-sizing: border-box;
    background-color: rgba(255, 255, 255, 0.1); /* Slight transparency */
}

h1 {
    color: white;
    font-weight: 700;
    font-size: 36px;
    text-align: center;
    margin-bottom: 20px;
}

.info {
    margin-top: 20px;
}

.info p {
    font-size: 16px;
    line-height: 1.6;
    color: white;
}

a {
    display: block;
    margin-top: 20px;
    text-align: center;
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}    
.btn {
    width: 200px;
    font-weight: 500;
    padding: 8px 10px;
    background: #ffffff;
    text-decoration: none;
    border-radius: 10px;
    margin-top: 16px;
    color: #000000;
} 
.btn {
    border: unset;
    border-radius: 15px;
    color: #212121;
    z-index: 1;
    background: #e8e8e8;
    position: relative;
    font-weight: 1000;
    font-size: 15px;
    -webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
    box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
    transition: all 250ms;
    overflow: hidden;
}
   
.btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 0;
    border-radius: 15px;
    background-color: #212121;
    z-index: -1;
    -webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
    box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
    transition: all 250ms
}
   
.btn:hover {
    color: #e8e8e8;
}
   
.btn:hover::before {
    width: 100%;
}

    </style>
</head>

<body>
    <div class="container">
        <h1>Your Account Information</h1>
        <div class="info">
            <p><strong>Username:</strong> <?php echo $username; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo $birthday; ?></p>
        </div>
        <a href="home.php" class="btn">Back</a>
    </div>
</body>

</html>
