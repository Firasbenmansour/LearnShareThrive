<?php
session_start(); // Démarre la session
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session

$filename = 'data/users.csv';
$separater = ',';
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$birthday = $_POST['birthday'];
$new_id = count(file($filename));

if (add_user($filename, $username, $password, $email, $birthday, $separater, $new_id)) {
    session_start();
    echo "ACCOUNT CREATED SUCCESSFULLY.";
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $username; // Corrected variable name
    $_SESSION["id"] = $new_id;
    echo '<meta http-equiv="refresh" content="1; url=index.html">';
    } else {
        echo "Erreur lors de la création du compte.";
        echo '<meta http-equiv="refresh" content="1; url=inscription.html">';
        exit(); // Rediriger immédiatement après l'affichage du message
    }


// Function to add a new user to the CSV file if the username does not already exist
function add_user($filename, $username, $password, $email, $birthday, $separater, $new_id) {
    $file = fopen($filename, "r");
    if ($file) {
        while ($line = fgetcsv($file, 1024, $separater)) {
            if ($line[1] === $username) {
                echo "Le login utilisateur existe déjà - Choisir un autre login.";
                echo '<meta http-equiv="refresh" content="2; url=register.html">';
                exit();
            }
        }
        fclose($file);
    }

    // Data to add

    $new_row = [
        'Colonne0' => $new_id,
        'Colonne1' => $username,
        'Colonne2' => $password,
        'Colonne3' => $email,
        'Colonne4' => $birthday,
    ];

    // Open the file in append mode
    $file = fopen($filename, 'a');
    if ($file) {
        fputcsv($file, $new_row, $separater);
        fclose($file);
        return true;
    } else {
        return false;
    }
}
?>
