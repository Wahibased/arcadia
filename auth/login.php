<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier les informations de connexion
        $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirection vers le dashboard
            header('Location: ../dashboard/dashboard.php');
            exit;
        } else {
            $error = 'Email ou mot de passe incorrect.';
        }
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
?>

<form action="login.php" method="post" class="login-form" id="login-form">
        <h3>Login Admin</h3>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <input type="text" placeholder="Nom d'utilisateur / Email" name="username" class="box" required />
        <input type="password" placeholder="Mot de passe" name="password" class="box" required />
        <div class="remember">
            <input type="checkbox" name="remember" id="remember-me" />
            <label for="remember-me">Se souvenir de moi</label>
        </div>
        <button type="submit" class="btn">Connexion</button>
    </form>
</body>
</html>
