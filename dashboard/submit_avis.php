<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE avis_visiteurs SET approved = 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM avis_visiteurs WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}

$stmt = $pdo->prepare("SELECT id, pseudo, avis FROM avis_visiteurs WHERE approved = 0");
$stmt->execute();
$avis = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard - Zoo Arcadia</title>
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
        <section id="manage-avis">
            <h2>Gérer les avis</h2>
            <?php foreach ($avis as $avi): ?>
                <div class="avis">
                    <h3><?php echo htmlspecialchars($avi['pseudo']); ?></h3>
                    <p><?php echo htmlspecialchars($avi['avis']); ?></p>
                    <form action="dashboard.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $avi['id']; ?>">
                        <button type="submit" name="approve" class="btn">Approuver</button>
                        <button type="submit" name="delete" class="btn">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Zoo Arcadia. Tous droits réservés.</p>
    </footer>
</body>
</html>




