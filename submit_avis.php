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

$stmt = $pdo->prepare("SELECT pseudo, avis FROM avis_visiteurs WHERE approved = 1");
$stmt->execute();
$avis = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Accueil - Zoo Arcadia</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="habitats.html">Habitats</a></li>
                <li><a href="avis.html">Avis</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="dashboard.html">Dashboard</a></li>
                <li class="admin-login">
                    <a href="connexion.html"><i class="fas fa-user"></i> Connexion</a></li>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="avis">
            <h2>Les avis des visiteurs</h2>
            <?php foreach ($avis as $avi): ?>
                <div class="avis">
                    <h3><?php echo htmlspecialchars($avi['pseudo']); ?></h3>
                    <p><?php echo htmlspecialchars($avi['avis']); ?></p>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Zoo Arcadia. Tous droits réservés.</p>
    </footer>
</body>
</html>

