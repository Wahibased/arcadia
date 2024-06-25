<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet"  href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />
    <script src="/assets/js/script.js" defer></script>
    <title>zoo arcadia</title>
</head>
<body>
    <!-- header -->
    <header class="header">
        <a href="#" class="logo"><img src="assets/image/logo.jpg" alt="Logo" /></a>
        <nav class="navbar">
            <ul>
                <li><a href="#Services">Services</a></li>
                <li><a href="#habitats">Habitats</a></li>
                <li><a href="#avis">Avis</a></li>
                <li><a href="contact">Contact</a></li>
            </ul>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="login-btn" class="fas fa-user"></div>
        </div>
        <form action="login.php" method="post" class="login-form">
            <h3>Login Admin</h3>
            <input type="text" placeholder="Nom d'utilisateur / Email" name="username" class="box" required />
            <input type="password" placeholder="Mot de passe" name="password" class="box" required />
            <div class="remember">
                <input type="checkbox" name="remember" id="remember-me" />
                <label for="remember-me">Se souvenir de moi</label>
            </div>
            <button type="submit" class="btn">Connexion</button>
        </form>
    </header>
