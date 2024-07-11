<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php'; // Charger automatiquement les dépendances avec Composer

function getMailer() {
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur
        $mail->isSMTP(); // Utiliser SMTP
        $mail->Host = 'smtp.gmail.com'; // Adresse du serveur SMTP de Gmail
        $mail->SMTPAuth = true; // Activer l'authentification SMTP
        $mail->Username = 'wahibaharoun78@gmail.com'; // Votre adresse email Gmail
        $mail->Password = 'qfev lemw eoml pltm'; // Votre mot de passe Gmail
        $mail->SMTPSecure = 'tls'; // Activer le cryptage TLS
        $mail->Port = 587; // Port TCP à utiliser pour se connecter au serveur SMTP

        // Entêtes de l'email
        $mail->setFrom('wahibaharoun78@gmail.com', 'Zoo Arcadia'); // L'adresse email de l'expéditeur

    } catch (Exception $e) {
        echo "Le message n'a pas pu être configuré. Erreur de Mailer: {$mail->ErrorInfo}";
    }

    return $mail;
}
