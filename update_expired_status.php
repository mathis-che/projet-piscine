<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "projet";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer l'ID de l'article
$article_id = intval($_POST['articleId']);

// Mettre à jour la valeur expired de l'article
$sql = "UPDATE item SET expired = 1 WHERE ID = $article_id";
if ($conn->query($sql) === TRUE) {
    echo "Article mis à jour avec succès";
} else {
    echo "Erreur lors de la mise à jour de l'article: " . $conn->error;
}

$conn->close();
?>
