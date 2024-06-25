<?php
include 'config/db.php'; // Assure que db.php contient la configuration de la connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['nom'];
    $avis = $_POST['avis'];

    // Préparez et exécutez l'insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO avis_visiteurs (pseudo, avis, approved) VALUES (:pseudo, :avis, 0)");
    $stmt->execute(['pseudo' => $pseudo, 'avis' => $avis]);

    echo "Votre avis a été soumis pour validation.";
}
?>
