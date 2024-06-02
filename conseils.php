<?php
$conn = new mysqli('localhost', 'root', 'root', 'projet');

session_start();

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
    <link rel="icon" type="image/png" href="logo.jpg" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../image/logo.jpg"/>
	<title>Nos conseils pour vous</title>
    <link rel="stylesheet" href="../css/conseils.css">
    <link rel="stylesheet" href="../css/agora.css">
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
    <h1>Nos conseils pour vous ce mois-ci</h1>
    <table>
        <tr>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 1">
                </a>
                <p>Description de l'article 1</p>
                <p>Prix: 20€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 2">
                </a>
                <p>Description de l'article 2</p>
                <p>Prix: 30€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 3">
                </a>
                <p>Description de l'article 3</p>
                <p>Prix: 25€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 4">
                </a>
                <p>Description de l'article 4</p>
                <p>Prix: 40€</p>
            </td>
        </tr>
        <tr>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 5">
                </a>
                <p>Description de l'article 5</p>
                <p>Prix: 15€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 6">
                </a>
                <p>Description de l'article 6</p>
                <p>Prix: 35€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 7">
                </a>
                <p>Description de l'article 7</p>
                <p>Prix: 50€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 8">
                </a>
                <p>Description de l'article 8</p>
                <p>Prix: 45€</p>
            </td>
        </tr>
        <tr>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 9">
                </a>
                <p>Description de l'article 9</p>
                <p>Prix: 28€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 10">
                </a>
                <p>Description de l'article 10</p>
                <p>Prix: 22€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 11">
                </a>
                <p>Description de l'article 11</p>
                <p>Prix: 60€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 12">
                </a>
                <p>Description de l'article 12</p>
                <p>Prix: 55€</p>
            </td>
        </tr>
        <tr>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 13">
                </a>
                <p>Description de l'article 13</p>
                <p>Prix: 70€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                <img src="../image/bmw.png" alt="Article 14">
                <p>Description de l'article 14</p>
                <p>Prix: 80€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 15">
                </a>
                <p>Description de l'article 15</p>
                <p>Prix: 65€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 16">
                </a>
                <p>Description de l'article 16</p>
                <p>Prix: 75€</p>
            </td>
        </tr>
        <tr>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 17">
                </a>
                <p>Description de l'article 17</p>
                <p>Prix: 85€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 18">
                </a>
                <p>Description de l'article 18</p>
                <p>Prix: 90€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 19">
                </a>
                <p>Description de l'article 19</p>
                <p>Prix: 95€</p>
            </td>
            <td> <a href="tout_parcourir.php">
                    <img src="../image/bmw.png" alt="Article 20">
                </a>
                <p>Description de l'article 20</p>
                <p>Prix: 100€</p>
            </td>
        </tr>
    </table>
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