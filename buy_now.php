<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "agorafrancia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$article_id = intval($_POST['articleId']);

$sql = "SELECT * FROM item WHERE ID = $article_id AND type_vente = 'vente_directe'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Supprimer l'article acheté de la base de données ou marquer comme vendu
    $sql = "DELETE FROM item WHERE ID = $article_id AND type_vente = 'vente_directe'";
    if ($conn->query($sql) === TRUE) {
        echo "Article acheté avec succès!";
    } else {
        echo "Erreur lors de l'achat de l'article: " . $conn->error;
    }
} else {
    echo "Article introuvable ou déjà vendu.";
}

$conn->close();
?>
