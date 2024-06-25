<?php
$conn = new mysqli("localhost", "root", "", "zoo_arcadia");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $date_creation = date('Y-m-d H:i:s');

    // Générer un username unique
    $username = strtolower(explode(' ', $nom)[0]) . rand(1000, 9999);

    // Insérer l'utilisateur dans la base de données
    $sql = "INSERT INTO utilisateurs (nom, email, role, date_creation) VALUES ('$nom', '$email', '$role', '$date_creation')";
    
    if ($conn->query($sql) === TRUE) {
        // Envoyer un e-mail à l'utilisateur
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
        <p>Veuillez contacter l'administrateur pour obtenir votre mot de passe.</p>
        <p>Cordialement,<br>Zoo Arcadia</p>
        </body>
        </html>
        ";
        
        // Pour envoyer un e-mail HTML, l'en-tête Content-type doit être défini
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // En-têtes supplémentaires
        $headers .= 'From: noreply@zooarcadia.com' . "\r\n";
        
        mail($to, $subject, $message, $headers);

        echo "Utilisateur ajouté et e-mail envoyé.";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
