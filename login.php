<?php
session_start();

$filename = 'data/users.csv';
$separater = ',';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate credentials
    if (check_credentials($filename, $username, $password, $separater)) {
        $_SESSION["user"] = $username; // Store username in session
        header("Location: home.php"); // Redirect to home.php
        exit();
    } else {
        $_SESSION["error"] = "Invalid username or password. Please try again.";
        header("Location: index.php"); // Redirect back to login page
        exit();
    }
}

function check_credentials($filename, $username, $password, $separater) {
    $file = fopen($filename, "r");
    if ($file) {
        while ($line = fgetcsv($file, 1024, $separater)) {
            $stored_login = $line[1];
            $stored_password = $line[2];
            if ($stored_login === $username && $stored_password === $password) {
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
                $_SESSION["id"] = $line[0]; 
                fclose($file);
                return true;
            }
        }
        fclose($file);
    }
    return false;
}
?>
