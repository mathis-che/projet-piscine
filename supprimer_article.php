<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "projet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vider la table enchères
$sql_clear_encheres = "TRUNCATE TABLE enchères";
if ($conn->query($sql_clear_encheres) !== TRUE) {
    echo "Erreur lors de la suppression des enchères expirées: " . $conn->error . "\n";
}

// Supprimer les articles expirés
$sql = "DELETE FROM articles WHERE fin_enchere < NOW() AND type_vente = 'enchere' AND expired = TRUE";
if ($conn->query($sql) !== TRUE) {
    echo "Erreur lors de la suppression des articles expirés: " . $conn->error . "\n";
} else {
    echo "Les articles expirés ont été supprimés avec succès.\n";
}

$conn->close();
?>
