<?php
session_start();

$conn = new mysqli('localhost', 'root', 'root', 'projet');

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if (empty($_SESSION['user_id'])) {
    $conte = 'Se connecter';
} else {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT rang FROM utilisateurs WHERE id_utilisateur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $conte = 'Votre compte';
    if ($row && ($row['rang'] == 2 || $row['rang'] == 3)) {
        $conte1 = 1;
    } else {
        $conte1 = 2;
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
}

$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../image/logo.jpg" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="logo.jpg"/>
	<title>vente</title>
    <link rel="stylesheet" href="../css/principale.css">
    <link rel="stylesheet" href="../css/compte.css">
</head>
<body>
	<div class="wrapper">
        <header>
            <h1>Agora Francia</h1>
            <img src="../image/logo.png" alt="Logo du site" class="logo">
        </header>
        <nav>
            <ul>
                <li><a href="accueil.php" class="active">Accueil</a></li>
                <li><a href="tout_parcourir.php">Tout parcourir</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="panier.php">Panier</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn"><?php echo $conte; ?></a>
                    <div class="dropdown-content">
                        <?php
                        if($conte1 == 1){
                            echo '<a href="compte.php">profil</a>';
                            echo '<a href="vente.php">Mise en vente</a>';
                        } 
                        elseif($conte1 == 2){
                            echo '<a href="compte.php">profil</a>';
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
                $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $user_id = $row['id_utilisateur'];
                    $nom_utilisateur = $row['nom_utilisateur'];
                    $email = $row['email'];
                } else {
                    echo "Aucun résultat trouvé pour cet utilisateur.";
                }

            
                    echo "<table>";
                        echo "<tr><th>Nom d'utilisateur :</th><td>" . htmlspecialchars($row["nom_utilisateur"]) . "</td></tr>";
                        echo "<tr><th>Email :</th><td>" . htmlspecialchars($row["email"]) . "</td></tr>";
                        echo "<tr><th>Rang :</th>";
                        if ($row["rang"] == 1){
                            echo "<td> Acheteur </td>";
                        } elseif ($row["rang"] == 2){
                            echo "<td> Vendeur </td>";
                        } elseif ($row["rang"] == 3){
                            echo "<td> Admin </td>";
                            $rang = 3;
                        }
                        echo "</tr>";
                    echo "</table>";

                    if($row["rang"] == 3){
                        echo '
                        <form method="post" action="vendeur.php">
                            <h2>Ajouter un vendeur</h2>
                            <label for="username">Nom d\'utilisateur:</label>
                            <input type="text" id="username" name="username" required>
                            
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                            
                            <label for="name">Nom:</label>
                            <input type="text" id="name" name="name" required>
                            
                            <button type="submit" name="add">Ajouter</button>
                        </form>
                        ';  
                        
                        if(isset($_GET["success2"]) && $_GET["success2"] == 1) {
                            echo '<script>alert("Le vendeur a été ajouté avec succès.");</script>';
                        } elseif(isset($_GET["error2"]) && $_GET["error2"] == 1) {
                            echo '<script>alert("Une erreur s\'est produite lors de l\'ajout du vendeur.");</script>';
                        }

                        $sql = "SELECT * FROM utilisateurs where rang = '2'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table>";
                            echo "<tr><th>Nom d'utilisateur</th><th>Email</th><th>Vendeur</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["nom_utilisateur"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>";
                                echo "<form action='vendeur.php' method='post'>";
                                echo "<input type='hidden' name='ID' value='" . $row["id_utilisateur"] . "'>";
                                echo "<button type='submit' name='del' class='del-button'>Supprimer</button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                    
                        }

                        if(isset($_GET["success"]) && $_GET["success"] == 1) {
                            echo '<script>alert("Le vendeur a été supprimé avec succès.");</script>';
                        } elseif(isset($_GET["error"]) && $_GET["error"] == 1) {
                            echo '<script>alert("Une erreur s\'est produite lors de la suppression du vendeur.");</script>';
                        }
                    
                    }
                    echo '
                        <form method="post" action="logout.php">
                            <button type="submit" name="logout" class="logout-button">Se déconnecter</button>
                        </form>
                    ';
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