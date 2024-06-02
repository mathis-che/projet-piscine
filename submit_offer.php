<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "projet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$articleId = $_POST['articleId'];
$offerValue = $_POST['offerValue'];
$minOfferValue = $_POST['minOfferValue'];

if ($offerValue >= $minOfferValue) {
    $sql = "INSERT INTO offres (article_id, valeur_offre, date_offre) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $articleId, $offerValue);
    if ($stmt->execute()) {
        echo "Offre soumise avec succès.";
    } else {
        echo "Erreur lors de la soumission de l'offre.";
    }
    $stmt->close();
} else {
    echo "Erreur: L'offre doit être au moins de " . $minOfferValue . " €.";
}

$conn->close();
?>
