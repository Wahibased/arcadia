<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $email = $_POST['email'];

    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Remplacez par votre hôte SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'wahibaharoun78@gmail.com'; // Remplacez par votre adresse email
        $mail->Password = 'aogf fybq xqkv ilcf'; // Remplacez par votre mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Paramètres de l'email
        $mail->setFrom('wahi8436@gmail.com', 'Visiteur du Zoo');
        $mail->addAddress('wahibaharoun78@gmail.com', 'Zoo Arcadia'); // Remplacez par l'email du zoo
         //contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body    = '<p>' . htmlspecialchars($description) . '</p><p>Email du visiteur: ' . htmlspecialchars($email) . '</p>';

        $mail->send();
        echo 'Message envoyé avec succès.';
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur de Mailer: {$mail->ErrorInfo}";
    }
}
?>
