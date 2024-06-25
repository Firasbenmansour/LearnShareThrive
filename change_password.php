<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.html");
    exit();
}

// Initialize variables
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$self_id = $_SESSION['id'];
$user_found = false;

// Open CSV file for reading and writing
$users_file = fopen("data/users.csv", "r+");
$temp_file = fopen("data/temp_users.csv", "w");

// Iterate through the CSV to find and update the user's password
while (($ligne = fgetcsv($users_file)) !== false) {
    if ($ligne[0] == $self_id) {
        $user_found = true;
        if ($ligne[2] == $current_password) { // Validate current password
            $ligne[2] = $new_password; // Update with new password
            $_SESSION['success'] = "Password changed successfully.";
        } else {
            $_SESSION['error'] = "Current password is incorrect.";
            fclose($users_file);
            fclose($temp_file);
            unlink("data/temp_users.csv");
            header("Location: account.php");
            exit();
        }
    }
    fputcsv($temp_file, $ligne);
}

// Close the file handles
fclose($users_file);
fclose($temp_file);

// Replace the old CSV file with the updated one
if ($user_found) {
    rename("data/temp_users.csv", "data/users.csv");
} else {
    unlink("data/temp_users.csv");
    $_SESSION['error'] = "User not found.";
}

header("Location: account.php");
exit();
?>
