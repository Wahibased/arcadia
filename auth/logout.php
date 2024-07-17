<?php
session_start(); // Démarrer la session

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire la session elle-même
session_destroy();

// Rediriger vers la page de connexion
header('Location: login.html');
exit();
