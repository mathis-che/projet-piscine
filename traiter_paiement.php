<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "agorafrancia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cardType = $_POST['cardType'];
$cardNumber = $_POST['cardNumber'];
$cardName = $_POST['cardName'];
$expiryDate = $_POST['expiryDate'];
$cvv = $_POST['cvv'];

$errors = [];

if (!preg_match('/^[0-9]{13,16}$/', $cardNumber)) {
    $errors[] = 'Numéro de carte invalide.';
}


if (!preg_match('/^[a-zA-Z ]*$/', $cardName)) {
    $errors[] = 'Nom sur la carte invalide.';
}

if (!preg_match('/^(0[1-9]|1[0-2])[\/]([0-9]{2})?$/', $expiryDate)) {
    $errors[] = 'Date d\'expiration invalide.';
}

if (!preg_match('/^[0-9]{3,4}$/', $cvv)) {
    $errors[] = 'Code de sécurité (CVV) invalide.';
}
if (empty($errors)) {
    $sql = "SELECT * FROM utilisateurs WHERE numcarte = ? AND datecarte = ? AND cvvcarte = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $cardNumber, $expiryDate, $cvv);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Les informations de la carte de crédit sont valides, traitez la commande ici
        // Par exemple, vous pouvez enregistrer la commande dans la base de données, envoyer un e-mail de confirmation, etc.

        header('Location: commande_validee.php');
        exit;
    } else {
        $errors[] = 'Les informations de la carte de crédit ne correspondent à aucun utilisateur.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur de paiement</title>
</head>
<body>
    <h1>Erreur de paiement</h1>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="panier.php">Retourner au panier</a>
</body>
</html>
