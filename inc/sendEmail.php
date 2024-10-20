<?php

// Remplacez cela par votre propre adresse email
$siteOwnersEmail = 'nina.chastanier14@gmail.com';

if ($_POST) {

    $name = trim(stripslashes($_POST['Nom']));
    $email = trim(stripslashes($_POST['Adresse mail']));
    $subject = trim(stripslashes($_POST['Objet']));
    $contact_message = trim(stripslashes($_POST['Message']));

    // Initialiser un tableau d'erreurs
    $error = [];

    // Vérifier le nom
    if (strlen($name) < 2) {
        $error['name'] = "Veuillez entrer votre nom.";
    }
    // Vérifier l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Veuillez entrer une adresse mail valide.";
    }
    // Vérifier le message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Veuillez entrer votre message, il doit contenir au minimum 15 caractères.";
    }
    // Sujet
    if ($subject == '') {
        $subject = "Soumission du formulaire de contact";
    }

    // Initialiser le message
    $message = '';
    // Définir le message
    $message .= "Email de : " . $name . "<br />";
    $message .= "Adresse email : " . $email . "<br />";
    $message .= "Message : <br />";
    $message .= $contact_message;
    $message .= "<br /> ----- <br /> Cet email a été envoyé depuis le formulaire de contact de votre site. <br />";

    // Définir l'en-tête "From"
    $from = $name . " <" . $email . ">";

    // En-têtes de l'email
    $headers = "De : " . $from . "\r\n";
    $headers .= "Répondre à : " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    // Si aucune erreur de validation, envoyer l'email
    if (empty($error)) {
        ini_set("sendmail_from", $siteOwnersEmail); // pour un serveur Windows
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) {
            echo "OK";
        } else {
            echo "Une erreur est survenue lors de l'envoi de votre message. Veuillez réessayer.";
        }
    } else {
        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;

        echo $response;
    }
}
?>
