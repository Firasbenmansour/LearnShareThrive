<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // pour Nettoyez et validez les données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // Vérifiez que tous les champs sont remplis
    if ($nom && $email && $message) {
        // Définir l'adresse email du destinataire
        $to = 'dafnasofack@gmail.com';

        // Définir le sujet de l'email
        $subject = 'Nouveau message de contact';

        // Définir les en-têtes de l'email
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

        // Construire le corps de l'email
        $body = "Nom: $nom\n";
        $body = "Prenom: $prenom\n";
        $body .= "Email: $email\n\n";
        $body .= "Message:\n$message\n";

        // Envoyer l'email
        if (mail($to, $subject, $body, $headers)) {
            echo 'Merci pour votre message. Il a été envoyé avec succès.';
        } else {
            echo 'Désolé, une erreur s\'est produite lors de l\'envoi de votre message. Veuillez réessayer plus tard.';
        }
    } else {
        echo 'Veuillez remplir tous les champs du formulaire.';
    }
} else {
    // Rediriger vers la page de contact si le formulaire n'a pas été soumis
    header('Location: contact.html');
    exit();
}
?>

