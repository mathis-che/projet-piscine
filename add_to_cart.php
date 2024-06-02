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
$user_id = 1;  // Vous pouvez obtenir l'ID de l'utilisateur connecté par session ou autre méthode
$type_vente = $_POST['typeVente'];

// Vérifier si l'article existe et récupérer ses informations
$sql = "SELECT Prix, Nom, Description, Photo FROM item WHERE ID = $article_id AND type_vente = '$type_vente'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $prix = $row['Prix'];
    $nom = $row['Nom'];
    $description = $row['Description'];
    $photo = $row['Photo'];

    // Ajouter l'article au panier
    $sql = "INSERT INTO panier (article_id, user_id, prix, type_vente, nom, description, photo) VALUES ($article_id, $user_id, $prix, '$type_vente', '$nom', '$description', '$photo')";
    if ($conn->query($sql) === TRUE) {
        echo "Article ajouté au panier avec succès!";
        
        // Mettre à jour l'état de l'article à expiré après l'avoir ajouté au panier
        updateExpiredStatus($article_id, $type_vente);
    } else {
        echo "Erreur lors de l'ajout de l'article au panier: " . $conn->error;
    }
} else {
    echo "Article introuvable.";
}

$conn->close();

function updateExpiredStatus($article_id, $type_vente) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "agorafrancia";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Vérifier si l'article est toujours disponible
    $check_sql = "SELECT ID FROM item WHERE ID = $article_id AND type_vente = '$type_vente' AND expired = 0";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Mettre à jour la valeur expired de l'article à 1
        $update_sql = "UPDATE item SET expired = 1 WHERE ID = $article_id AND type_vente = '$type_vente'";
        
        if ($conn->query($update_sql) === TRUE) {
            // Éventuellement, vous pouvez afficher un message ou effectuer d'autres actions
        } else {
            echo "Erreur lors de la mise à jour de l'état de l'article: " . $conn->error;
        }
    } else {
        echo "L'article n'est plus disponible.";
    }

    $conn->close();
}

?>
