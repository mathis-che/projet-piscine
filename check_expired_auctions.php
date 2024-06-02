<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "agorafrancia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT articles.id, articles.prix_actuel, encheres.user_id
        FROM articles
        INNER JOIN encheres ON articles.id = encheres.article_id
        WHERE articles.type_vente = 'enchere'
        AND articles.fin_enchere < NOW()
        AND encheres.montant = (
            SELECT MAX(montant)
            FROM encheres
            WHERE article_id = articles.id
        )";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $article_id = $row["id"];
        $user_id = $row["user_id"];
        $prix = $row["prix_actuel"];

        // Ajouter l'article au panier
        $sql = "INSERT INTO panier (article_id, user_id, prix, type_vente) VALUES ($article_id, $user_id, $prix, 'enchere')";
        if ($conn->query($sql) === TRUE) {
            echo "Article $article_id ajouté au panier de l'utilisateur $user_id avec succès!\n";
        } else {
            echo "Erreur lors de l'ajout de l'article $article_id au panier de l'utilisateur $user_id: " . $conn->error . "\n";
        }
    }
} else {
    echo "Aucune enchère expirée à traiter.\n";
}

$conn->close();
?>
