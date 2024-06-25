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
        $email = $ligne[3];
        $birthday = $ligne[4];
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
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Chivo:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <style>
* {
    margin: 0;  
    padding: 0;
    font-family: "Chivo", sans-serif;
    box-sizing: border-box;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(12deg, #000000, #093c41, #0c895e);
    background-size: 600% 600%;
    -webkit-animation: AnimationName 34s ease infinite;
    -moz-animation: AnimationName 34s ease infinite;
    animation: AnimationName 34s ease infinite;
}

@-webkit-keyframes AnimationName {
    0%{background-position:56% 0%}
    50%{background-position:45% 100%}
    100%{background-position:56% 0%}
}
@-moz-keyframes AnimationName {
    0%{background-position:56% 0%}
    50%{background-position:45% 100%}
    100%{background-position:56% 0%}
}
@keyframes AnimationName {
    0%{background-position:56% 0%}
    50%{background-position:45% 100%}
    100%{background-position:56% 0%}
}

.page{
    min-height: 100vh;

}
.container {
    width: 550px;
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
.btn{
    width: 130px;
    font-weight: 500;
    padding: 8px 10px;
    background: #ffffff;
    text-decoration: none;
    border-radius: 10px;
    margin-top: 16px;
    color: #000000;
    float: right;
} 
form button{
    font-weight: 500;
    padding: 8px 10px;
    background: #ffffff;
    text-decoration: none;
    border-radius: 10px;
    margin-top: 10px;
    color: #000000;
} 
.btn,form button{
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
   
.btn::before, form button::before  {
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
   
.btn:hover,form button:hover {
    color: #e8e8e8;
}
   
.btn:hover::before,form button:hover::before  {
    width: 100%;
}

.change-password h2{
    color: white;
    margin-top: 15px;
}
.change-password  input{
    margin: 5px 0px;
    background: rgba(255, 255, 255, .2);
    border: none;
    outline: none;
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 10px;
    font-size: 16px;
    color: white;
    padding: 10px;
    width: 100%;
}
.change-password  input::placeholder{
    color:rgb(255, 255, 255);
    
}
.error,.success{
    margin-top: 10px;
    color: white;
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
        <div class="change-password">
            <h2>Change Password</h2>
            <form action="change_password.php" method="post">
                <div class="form-group">
                    <input type="password" name="current_password" placeholder="Current Password" id="current_password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="new_password" placeholder="New Password" id="new_password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Change Password</button>
                </div>
            </form>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<p class="success">' . $_SESSION['success'] . '</p>';
                unset($_SESSION['success']);
            }
            ?>
        </div>
        <a href="home.php" class="btn">Back</a>
    </div>
</body>

</html>
