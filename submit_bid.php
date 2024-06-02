<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "agorafrancia";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer et valider les entrées
$article_id = intval($_POST['articleId']);
$bid_value = floatval($_POST['bidValue']);

if ($article_id <= 0 || $bid_value <= 0) {
    die("Invalid input values");
}

// Vérifier le prix actuel de l'article
$sql = "SELECT prix_actuel FROM item WHERE ID = $article_id";
$result = $conn->query($sql);

if ($result === FALSE) {
    die("Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($bid_value > $row['prix_actuel']) {
        // Insérer une nouvelle enchère
        $sql = "INSERT INTO enchères (article_id, montant) VALUES ($article_id, $bid_value)";
        if ($conn->query($sql) === TRUE) {
            // Mettre à jour le prix actuel de l'article
            $sql = "UPDATE item SET prix_actuel = $bid_value WHERE ID = $article_id";
            if ($conn->query($sql) === TRUE) {
                echo $bid_value; // Retourner la nouvelle valeur du prix actuel pour mise à jour du frontend
            } else {
                echo "Erreur lors de la mise à jour de l'article: " . $conn->error;
            }
        } else {
            echo "Erreur lors de l'insertion de l'enchère: " . $conn->error;
        }
    } else {
        echo "Votre offre doit être supérieure au prix actuel!";
    }
} else {
    echo "Article introuvable!";
}

$conn->close();
?>
