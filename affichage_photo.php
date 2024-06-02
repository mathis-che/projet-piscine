<?php
session_start();

$conn = new mysqli('localhost', 'root', 'root', 'projet');

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if (empty($_SESSION['user_id'])) {
    $conte = 'Se connecter';
} else {
    $conte = 'Votre compte';
}

// Récupérer l'ID de l'image à afficher
$image_id = 1;

if ($image_id > 0) {
    $sql = "SELECT Photo FROM item WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $image_id);
    $stmt->execute();
    $stmt->bind_result($photo);
    $stmt->fetch();

    if ($photo) {
        // Définir le type de contenu
        header("Content-type: image/jpeg");
        echo $photo;
    } else {
        echo "Image non trouvée.";
    }

    $stmt->close();
} else {
    echo "ID d'image non spécifié.";
}

$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="logo.jpg" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="logo.jpg" />
    <title>vente</title>
    <link rel="stylesheet" href="../css/principale.css">
</head>

<body>
    <div class="wrapper">
        <header>
            <h1>Agora Francia</h1>
            <img src="logo.png" alt="Logo du site" class="logo">
        </header>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="tout_parcourir.php">Tout parcourir</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="panier.php">Panier</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn"><?php echo $conte; ?></a>
                    <div class="dropdown-content">
                        <?php
                        if($conte == 'Votre compte'){
                            echo '<a href="compte.php">profil</a>';
                            echo '<a href="vente.php">Mise en vente</a>';
                        } 
                        else {
                            echo '<a href="login.php">Acheteur</a>';
                            echo '<a href="login_vendeur.php">Vendeur</a>';
                        }
                        ?>
                    </div>
                </li>
            </ul>
        </nav>
        <section>
            <?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Exécuter une requête pour obtenir les informations des articles
$sql = "SELECT ID, Nom FROM item";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['ID'];
        $nom = $row['Nom'];
        echo "<div>";
        echo "<h2>$nom</h2>";
        echo "<img src='afficher_image.php?id=$id' alt='$nom' />";
        echo "</div>";
    }
} else {
    echo "Aucun article trouvé.";
}

$conn->close();
?>

        </section>
        <footer>
            <ul>
                <ul>Contact: <a href="contact.php">info@agorafrancia.fr</a></ul>
                <ul>Tel : 01.02.03.04.05</ul>
                <ul>Adresse : 37 Quai de Grenelle </ul>
                <br>
                <ul>&copy; 2024 Agora Francia</ul>
            </ul>
        </footer>
    </div>
</body>

</html>