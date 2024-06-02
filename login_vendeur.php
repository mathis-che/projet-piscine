<?php
ob_start();
session_start();
$conn = new mysqli('localhost', 'root', 'root', 'projet');

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
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
    <link rel="stylesheet" href="../css/login.css">

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
        <h4>Se connecter</h4>
        <form method="post" action="login_vendeur.php">
            <div class="form-group">
                <input type="text" name="login_username" class="form-style" placeholder="Nom d'utilisateur" id="login_username" autocomplete="off" required>
            </div>
            <div class="form-group">
                <input type="email" name="login_email" class="form-style" placeholder="email" id="login_password" autocomplete="off" required>
            </div>
            <button type="submit" name="login">Se connecter</button>
        </form>
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

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $database = "projet";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['login'])) {
            $login_username = $_POST['login_username'];
            $login_email = $_POST['login_email'];

            if (!empty($login_username) && !empty($login_email)) {
                $sql = "SELECT id_utilisateur, nom_utilisateur, email FROM utilisateurs WHERE nom_utilisateur = '$login_username' AND rang = 2";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row && $login_email == $row['email']) {
                    $_SESSION['user_id'] = $row['id_utilisateur'];
                    $user_name = $row['nom_utilisateur'];
                    setcookie("user_name_cookie_vendeur", $user_name, time() + 86400, "/");
                    header("Location: accueil.php");
                    exit();
                    
                } else {
                    echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect.');</script>";                }
            } else {
                echo "<script>alert('Veuillez saisir le nom d\'utilisateur et le mot de passe.');</script>";
            }
        }
    }

    $conn->close();
    ob_end_flush();
    ?>
</body>

</html>
