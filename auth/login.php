<?php
session_start();

//  informations de connexion à la base de données
$host = 'localhost';
$db = 'zoo_arcadia';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']) ? $_POST['remember'] : false;
    if (!empty($username) && !empty($password)) {
        // Préparez une instruction SQL pour éviter les injections SQL
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
 if ($admin && password_verify($password, $admin['password'])) {
            // Si l'utilisateur est authentifié, stockez ses informations dans la session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            header('Location: admin_dashboard.php'); // Rediriger vers le tableau de bord de l'admin
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <title>login Admin</title>
</head>
<body>
<div class="login-form">
    <h3>login Admin</h3>
    <?php if (isset($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="/auth/login.php" method="post">
        <input type="text" placeholder="Nom d'utilisateur / Email" name="username" class="box" required />
        <input type="password" placeholder="Mot de passe" name="password" class="box" required />
        <div class="remember">
            <input type="checkbox" name="remember" id="remember-me" />
            <label for="remember-me">Se souvenir de moi</label>
        </div>
        <button type="submit" class="btn">Connexion</button>
    </form>
</div>
</body>
</html>
