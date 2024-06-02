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

error_log("Tentative d'ajout de l'article expiré au panier, ID: $article_id");

$sql = "SELECT * FROM item WHERE ID = $article_id AND type_vente = 'enchere' AND expired = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $prix = $row['prix_actuel'];
    $nom = $row['Nom'];
    $description = $row['Description'];
    $photo = $row['Photo'];

    $sql = "INSERT INTO panier (article_id, user_id, prix, type_vente, nom, description, photo) 
            VALUES ($article_id, 1, $prix, 'enchere', '$nom', '$description', '$photo')";

    if ($conn->query($sql) === TRUE) {
        echo "Article ajouté au panier avec succès";
        error_log("Article ajouté au panier avec succès, ID: $article_id");
    } else {
        echo "Erreur lors de l'ajout de l'article au panier: " . $conn->error;
        error_log("Erreur lors de l'ajout de l'article au panier: " . $conn->error);
    }
} else {
    echo "Aucun article d'enchère expiré trouvé";
    error_log("Aucun article d'enchère expiré trouvé pour l'ID: $article_id");
}

$conn->close();
?>
