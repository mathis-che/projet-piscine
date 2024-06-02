<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$database = "projet";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupération des données du formulaire
$Categorie = isset($_POST['categorie']) ? $_POST['categorie'] : "";
$Nom = isset($_POST['nom']) ? $_POST['nom'] : "";
$rechercher = isset($_POST['Ajouter']) ? $_POST['Ajouter'] : "";

// Données électroniques
$prix_max_elec = isset($_POST['prix_elec']) ? $_POST['prix_elec'] : "";
$type = isset($_POST['type']) ? $_POST['type'] : "";
$couleur = isset($_POST['couleur']) ? $_POST['couleur'] : "";

// Données mode
$vetement = isset($_POST['vetement']) ? $_POST['vetement'] : "";
$prix_max_mode = isset($_POST['prix_mode']) ? $_POST['prix_mode'] : "";
$qualite = isset($_POST['qualite']) ? $_POST['qualite'] : "";
$taille = isset($_POST['taille']) ? $_POST['taille'] : "";

// Données art
$prix_max_art = isset($_POST['prix_art']) ? $_POST['prix_art'] : "";
$date_decouverte = isset($_POST['date_dec']) ? $_POST['date_dec'] : "";

// Gestion du téléchargement de la photo
$photo_blob = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $photo_blob = file_get_contents($_FILES['photo']['tmp_name']);
}

$id_user = $_SESSION['user_id'];

if ($rechercher == "Ajouter") {
    // Construction de la requête SQL
    if ($Categorie == "Art") {
        $sql = "INSERT INTO item (id_user, Nom, Photo, Prix, Categorie, Date_Decouverte) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ississ', $id_user, $Nom, $photo_blob, $prix_max_art, $Categorie, $date_decouverte);
    } elseif ($Categorie == "Mode") {
        $sql = "INSERT INTO item (id_user, Nom, Photo, Prix, Categorie, Qualite, Taille, Vetement) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ississss', $id_user, $Nom, $photo_blob, $prix_max_mode, $Categorie, $qualite, $taille, $vetement);
    } elseif ($Categorie == "Electronique") {
        $sql = "INSERT INTO item (id_user, Nom, Photo, Prix, Categorie, Couleur, Type_Appareil) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ississs', $id_user, $Nom, $photo_blob, $prix_max_elec, $Categorie, $couleur, $type);
    }

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "<script>alert('L\'article a été ajouté avec succès.'); window.location.href='vente.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'ajout de l\'article : '); window.location.href='vente.php';</script>" . $stmt->error;
    }

    // Fermeture de la connexion
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Le formulaire n\'a pas été soumis correctement.'); window.location.href='vente.php';</script>";
}
?>
