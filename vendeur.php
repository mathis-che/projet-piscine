<?php
$conn = new mysqli('localhost', 'root', 'root', 'projet');

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}
if(isset($_POST["del"])) {
    $id = $_POST["ID"];
    
    $sql = "DELETE FROM utilisateurs WHERE id_utilisateur = '$id' ";
    
    $stmt = $conn->prepare($sql);
    if($stmt->execute()) {
        header("Location: compte.php?success=1");
        exit;
    } else {
        header("Location: compte.php?error=1");
        exit;
    }
}

if(isset($_POST["add"])) {
    $id = $_POST["username"];
    $email = $_POST["email"];
    $nom = $_POST["name"];
    
    $sql = "INSERT INTO utilisateurs (nom_utilisateur, email, rang, nom) VALUES ('$id','$email', '2', '$nom')";
    
    $stmt = $conn->prepare($sql);
    if($stmt->execute()) {
        header("Location: compte.php?success2=1");
        exit; 
    } else {
        header("Location: compte.php?error2=1");
        exit;
    }
}
?>