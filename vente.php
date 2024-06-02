<?php
session_start();

$conn = new mysqli('localhost', 'root', 'root', 'projet');

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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
    <title>vente</title>
    <link rel="stylesheet" href="../css/principale.css">
    <style>
    table {
        width: 80%;
        margin: 20px auto;
        font-size: 18px;
        background-color: white;
        border-collapse: collapse;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="file"],
    input[type="email"],
    select {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        font-size: 18px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="submit"] {
        margin: 5px;
        padding: 10px 20px;
        font-size: 18px;
        border-radius: 5px;
        background-color: #4a90e2;
        color: white;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #357ABD;
    }
    </style>

    <script>
        function showCategoryQuestions() {
            var category = document.getElementById("categorie").value;
            var categories = ["electroniqueQuestions", "modeQuestions", "artQuestions"];
            categories.forEach(function(cat) {
                document.getElementById(cat).style.display = "none";
            });
            if (category === "Electronique") {
                document.getElementById("electroniqueQuestions").style.display = "table-row-group";
            } else if (category === "Mode") {
                document.getElementById("modeQuestions").style.display = "table-row-group";
            } else if (category === "Art") {
                document.getElementById("artQuestions").style.display = "table-row-group";
            }
        }
    </script>
</head>

<body>
    <div class="wrapper">
        <header>
            <h1>Agora Francia</h1>
            <img src="../image/logo.png" alt="Logo du site" class="logo">
        </header>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="tout_parcourir.php">Tout parcourir</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="panier.php">Panier</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn active"><?php echo $conte; ?></a>
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
            <h2>Ajouter un article</h2>
            <form id="rechercheForm" action="ajout_item.php" method="post" enctype="multipart/form-data">
                <table border="1">
                    <tr>
                        <td>Nom Du Produit</td>
                        <td><input type="text" name="nom" id="nom" required></td>
                    </tr>
                    <tr>
                        <td>Photo:</td>
                        <td><input type="file" name="photo" accept="image/*" required></td>
                    </tr>

                    <tr>
                        <td>Catégorie</td>
                        <td>
                            <select name="categorie" id="categorie" onchange="showCategoryQuestions()">
                                <option value="Electronique">Electronique</option>
                                <option value="Mode">Mode</option>
                                <option value="Art">Art</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Electronique -->
                    <tbody id="electroniqueQuestions" style="display: table-row-group;">
                        <tr>
                            <td>Prix</td>
                            <td><input type="number" name="prix_elec"></td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td><input type="text" name="type"></td>
                        </tr>
                        <tr>
                            <td>Couleur</td>
                            <td><input type="text" name="couleur"></td>
                        </tr>
                    </tbody>
                    <!-- Mode -->
                    <tbody id="modeQuestions" style="display: none;">
                        <tr>
                            <td>Vêtement</td>
                            <td><input type="text" name="vetement"></td>
                        </tr>
                        <tr>
                            <td>Prix</td>
                            <td><input type="number" name="prix_mode"></td>
                        </tr>
                        <tr>
                            <td>Qualité</td>
                            <td><input type="text" name="qualite"></td>
                        </tr>
                        <tr>
                            <td>Taille</td>
                            <td><input type="text" name="taille"></td>
                        </tr>
                    </tbody>
                    <!-- Art -->
                    <tbody id="artQuestions" style="display: none;">
                        <tr>
                            <td>Prix</td>
                            <td><input type="number" name="prix_art"></td>
                        </tr>
                        <tr>
                            <td>Année De Découverte</td>
                            <td><input type="number" name="date_dec"></td>
                        </tr>
                    </tbody>
                    <tr>
                        <td colspan="2" align="center">

                            <input type="submit" name="Ajouter" value="Ajouter" onclick="showCategoryQuestions();">

                        </td>
                    </tr>
                </table>
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