<?php
session_start();

// Détruire la session et les cookies
session_unset();
session_destroy();
setcookie("user_name_cookie", "", time() - 3600, "/"); // Supprime le cookie

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Rediriger vers la page de connexion
header("Location: login.php");
exit();
?>
