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

// Sélectionner les enchères expirées non traitées
$sql = "SELECT id, prix_actuel FROM item WHERE fin_enchere < NOW() AND type_vente = 'enchere' AND expired = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $item_id = $row['id'];
        $prix_actuel = $row['prix_actuel'];

        // Vérifier si l'article existe déjà dans le panier
        $sql_check_existing = "SELECT * FROM panier WHERE user_id = 1 AND item_id = $item_id";
        $result_existing = $conn->query($sql_check_existing);

        if ($result_existing->num_rows == 0) {
            // Ajouter l'article au panier avec expired == 1
            $sql_add_to_cart = "INSERT INTO panier (item_id, user_id, prix, type_vente) VALUES ($item_id, 1, $prix_actuel, 'enchere')";
            if ($conn->query($sql_add_to_cart) === TRUE) {
                // Mettre à jour le statut expired de l'article
                $sql_update_item = "UPDATE item SET expired = 1 WHERE id = $item_id";
                if ($conn->query($sql_update_item) === TRUE) {
                    echo "L'article $item_id a été ajouté au panier avec succès et marqué comme expiré.\n";
                } else {
                    echo "Erreur lors de la mise à jour de l'article $item_id: " . $conn->error . "\n";
                }
            } else {
                echo "Erreur lors de l'ajout de l'article $item_id au panier: " . $conn->error . "\n";
            }
        } else {
            echo "L'article $item_id est déjà dans votre panier.\n";
        }
    }
} else {
    echo "Aucune enchère expirée non traitée.\n";
}

$conn->close();
?>
