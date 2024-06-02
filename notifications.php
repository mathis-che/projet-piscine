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

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="../css/principale.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   
    <style>
           .wrapper {
             display: flex;
             flex-direction: column;
             min-height: 100px;
            }

            h2 {
           text-align: center;
           margin: 20px auto;
           padding: 10px;
           width: 50%;
           border-radius: 10px;
       }



    </style>

    <script>
        function showCategoryQuestions() {
            var category = document.getElementById("categorie").value;
            var categories = ["electroniqueQuestions", "modeQuestions", "artQuestions"];
            categories.forEach(function (cat) {
                document.getElementById(cat).style.display = "none";
            });
            if (category === "Electronique") {
                document.getElementById("electroniqueQuestions").style.display = "table-row-group";
            } else if (category === "Mode") {
                document.getElementById("modeQuestions").style.display = "table-row-group";
            } else if (category === "Art") {
                document.getElementById("artQuestions").style.display = "table-row-group";
            }

            // Afficher l'alerte
            document.getElementById("alerte").style.display = "block";
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
                <li><a href="notifications.php" class="active">Notifications</a></li>
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
<h2 class="animate-subtitle">Activez les Notifications ! <img id="sonerie" src="https://cdn-icons-png.flaticon.com/512/3239/3239958.png" alt="Ventes aux enchères"></h2>
<form id="rechercheForm" action="mieux_presenter.php" method="post">
    <table border="1">
        <tr>
            <td colspan="2" align="center"><b>Quel produit recherchez-vous ?</b></td>
        </tr>
        <tr>
            <td>Nom </td>
            <td><input type="text" name="nom" id="nom"></td>
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
            <td>Prix max</td>
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
            <td>Prix Max</td>
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
            <td>Prix max</td>
            <td><input type="number" name="prix_art"></td>
        </tr>
        <tr>
            <td>Année Découverte min</td>
            <td><input type="number" name="date_dec"></td>
        </tr>
        </tbody>
        <tr>
            <td>Votre e-mail</td>
            <td><input type="email" name="email" required></td>
        </tr>
        <tr>
            <td colspan="2" align="center">

            <input  type="submit" name="Rechercher" value="Rechercher" onclick="showCategoryQuestions();"> 

            </td>
        </tr>
    </table>
    <!-- Champ caché pour l'ID utilisateur -->
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <!-- <div id="alerte" class="alert" style="display: none;">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        Critère enregistré avec succès !
    </div> -->
    
</form>
    </section>
    <footer>
            <ul>
                <li>Contact: <a href="contact.php">info@agorafrancia.fr</a></li>
                <li>Tel : 01.02.03.04.05</li>
            </ul>
            <ul>
                <li>Adresse : 37 Quai de Grenelle </li>
                <li>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.351862863769!2d2.2872323999999997!3d48.8515004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6700497ee3ec5%3A0xdd60f514adcdb346!2s37%20Quai%20de%20Grenelle%2C%2075015%20Paris!5e0!3m2!1sfr!2sfr!4v1716902771892!5m2!1sfr!2sfr"
                            width="300" height="225" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </li>
                <li>&copy; 2024 Agora Francia</li>
            </ul>
        </footer>
</body>
</html>






