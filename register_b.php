<?php
session_start(); // Start the session

$filename = 'data/users.csv';
$separater = ',';
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$birthday = $_POST['birthday'];
$new_id = count(file($filename));

// Validate password, email, and birthday
if (validate_password($password) && validate_email($email) && validate_birthday($birthday)) {
    if (add_user($filename, $username, $password, $email, $birthday, $separater, $new_id)) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["id"] = $new_id;
        $_SESSION['message'] = "<div class='form-message'>ACCOUNT CREATED SUCCESSFULLY.</div>";
        header("Location: register.php");
        exit();
    } else {
        // Error message set in add_user function
        header("Location: register.php");
        exit();
    }
} else {
    $_SESSION['message'] = "<div class='error-message'>";
    if (!validate_password($password)) {
        $_SESSION['message'] .= "Password must be at least 7 characters long and include at least one uppercase letter and one lowercase letter.<br>";
    }
    if (!validate_email($email)) {
        $_SESSION['message'] .= "Invalid email format.<br>";
    }
    if (!validate_birthday($birthday)) {
        $_SESSION['message'] .= "You must be 7 years or older to use this platform.<br>";
    }
    $_SESSION['message'] .= "</div>";
    header("Location: register.php");
    exit();
}

// Function to validate the password
function validate_password($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z]).{7,}$/', $password);
}

// Function to validate the email format and check for uniqueness
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate the birthday (minimum age 10 years)
function validate_birthday($birthday) {
    // Validate date format (YYYY-MM-DD)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
        return false;
    }

    // Check minimum age of 10 years
    $min_age = new DateTime('now');
    $min_age->modify('-7 years');

    // Validate minimum age condition
    $date = new DateTime($birthday);
    return $date <= $min_age;
}

// Function to add a new user to the CSV file if the username and email do not already exist
function add_user($filename, $username, $password, $email, $birthday, $separater, $new_id) {
    $file = fopen($filename, "r");
    if ($file) {
        while ($line = fgetcsv($file, 1024, $separater)) {
            if ($line[1] === $username) {
                $_SESSION['message'] = "<div class='error-message'>Username already exists - Choose another username.</div>";
                fclose($file);
                return false;
            }
            if ($line[3] === $email) {
                $_SESSION['message'] = "<div class='error-message'>Email already exists - Choose another email.</div>";
                fclose($file);
                return false;
            }
        }
        fclose($file);
    }

    // Data to add
    $new_row = [
        $new_id,
        $username,
        $password,
        $email,
        $birthday,
    ];

    // Open the file in append mode
    $file = fopen($filename, 'a');
    if ($file) {
        fputcsv($file, $new_row, $separater);
        fclose($file);
        return true;
    } else {
        $_SESSION['message'] = "<div class='error-message'>Error creating account.</div>";
        return false;
    }
}
?>
