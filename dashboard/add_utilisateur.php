<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../Config/mailer_config.php';
require __DIR__ . '/../../vendor/autoload.php';

// Activer le rapport d'erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données avec PDO
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'zoo_arcadia';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer les erreurs PDO
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Fonction pour générer un mot de passe aléatoire
function generatePassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}

// Fonction pour hacher le mot de passe
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Traitement du formulaire d'ajout d'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $date_creation = date('Y-m-d H:i:s');

    // Générer un username unique
    $username = strtolower(explode(' ', $nom)[0]) . rand(1000, 9999);

    // Générer un mot de passe aléatoire
    $password = generatePassword();

    // Hacher le mot de passe pour le stockage en base de données
    $hashedPassword = hashPassword($password);

    // Insérer l'utilisateur dans la base de données avec requête préparée
    $sql = "INSERT INTO utilisateurs (nom, email, type, date_creation, username, mot_de_passe) 
            VALUES (:nom, :email, :type, :date_creation, :username, :mot_de_passe)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nom' => $nom,
        'email' => $email,
        'type' => $type,
        'date_creation' => $date_creation,
        'username' => $username,
        'mot_de_passe' => $hashedPassword
    ]);

    if ($stmt->rowCount() > 0) {
        // Afficher le mot de passe temporaire généré
        echo "Utilisateur ajouté avec succès. Le mot de passe temporaire est : " . $password;

        // Envoyer un e-mail à l'utilisateur avec le mot de passe (exemple)
        $to = $email;
        $subject = "Bienvenue à Zoo Arcadia";
        $message = "
        <html>
        <head>
        <title>Bienvenue à Zoo Arcadia</title>
        </head>
        <body>
        <p>Bonjour $nom,</p>
        <p>Votre compte a été créé avec succès. Votre nom d'utilisateur est: $username.</p>
        <p>Votre mot de passe temporaire est: $password.</p>
        <p>Veuillez contacter l'administrateur pour plus de détails.</p>
        <p>Cordialement,<br>Zoo Arcadia</p>
        </body>
        </html>
        ";

        // Pour envoyer un e-mail HTML, l'en-tête Content-type doit être défini
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // En-têtes supplémentaires
        $headers .= 'From: noreply@zooarcadia.com' . "\r\n";

        // Envoi de l'e-mail
        mail($to, $subject, $message, $headers);
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur.";
    }
}