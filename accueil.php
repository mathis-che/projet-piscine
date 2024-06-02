<?php
session_start();

$conn = new mysqli('localhost', 'root', 'root', 'projet');

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

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../image/logo.jpg" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia</title>
    <link rel="stylesheet" href="../css/agora1.css">
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
            <h2>Bienvenue sur Agora Francia</h2>
            <p>
                Découvrez Agora Francia, votre nouvelle plateforme en ligne dédiée à la vente de tout type de produits.
                Que vous soyez à la recherche d'un objet rare, d'une bonne affaire ou d'un achat immédiat, Agora Francia
                vous offre trois modes d'achat adaptés à vos besoins :
            </p>
            <ul>
                <li><strong>Ventes aux enchères</strong> : Participez à nos enchères en ligne pour tenter de remporter
                    des articles uniques et convoités au meilleur prix.</li>
                <li><strong>Négociations</strong> : Engagez-vous dans des négociations avec les vendeurs pour trouver un
                    accord qui satisfait les deux parties.</li>
                <li><strong>Achat direct</strong> : Achetez immédiatement les produits de votre choix sans attendre,
                    pour une expérience d'achat rapide et simple.</li>
            </ul>
            <p>
                Avec Agora Francia, profitez d'une diversité de produits, d'une communauté active et d'une plateforme
                sécurisée pour toutes vos transactions. Rejoignez-nous dès aujourd'hui et commencez votre expérience
                d'achat unique !
            </p>

            <div class="container">
                <h2>Notre sélection de la semaine pour vous :</h2>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                        <li data-target="#myCarousel" data-slide-to="4"></li>
                        <li data-target="#myCarousel" data-slide-to="5"></li>
                    </ol>

                    <div class="carousel-inner">

                        <div class="item active">
                            <a href="tout_parcourir.php">
                                <img src="../image/ordi.jpg" alt="ordi">

                                <div class="carousel-caption">
                                    <h3>PC Portable ASUS</h3>
                                </div>
                            </a>
                        </div>

                        <div class="item">
                            <a href="tout_parcourir.php">
                                <img src="../image/nike.png" alt="nike">
                                <div class="carousel-caption">
                                    <h3>Pull nike</h3>
                                </div>
                            </a>
                        </div>

                        <div class="item">
                            <a href="tout_parcourir.php">
                                <img src="../image/bmw.png" alt="bmw">
                                <div class="carousel-caption">
                                    <h3>BMW série 1</h3>
                                </div>
                            </a>
                        </div>

                        <div class="item">
                            <a href="tout_parcourir.php">
                                <img src="../image/mafe.jpg" alt="mafe">
                                <div class="carousel-caption">
                                    <h3>Le mafé originel</h3>
                                </div>
                            </a>
                        </div>

                        <div class="item">
                            <a href="tout_parcourir.php">
                                <img src="../image/joconde.jpg" alt="joconde">
                                <div class="carousel-caption">
                                    <h3>La Joconde</h3>
                                </div>
                            </a>
                        </div>

                        <div class="item">
                            <a href="tout_parcourir.php">
                                <img src="../image/vase.jpg" alt="vase">
                                <div class="carousel-caption">
                                    <h3>Vase aux enchères ! Foncez</h3>
                                </div>
                            </a>
                        </div>

                    </div>

                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>

                <br>
                <p> Cliquez <a href="conseils.php">ici</a> pour voir les articles que nous vous conseillons ! </p>
            </div>

        </section>
        <footer>
            <ul>
                <ul>Contact: <a href="contact.php">info@agorafrancia.fr</a></ul>
                <ul>Tel : 01.02.03.04.05</ul>
            </ul>
            <ul>
                <ul>Adresse : 37 Quai de Grenelle </ul>
                <ul>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.351862863769!2d2.2872323999999997!3d48.8515004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6700497ee3ec5%3A0xdd60f514adcdb346!2s37%20Quai%20de%20Grenelle%2C%2075015%20Paris!5e0!3m2!1sfr!2sfr!4v1716902771892!5m2!1sfr!2sfr"
                            width="300" height="225" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpoulcy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </ul>
                <ul>&copy; 2024 Agora Francia</ul>
            </ul>

        </footer>
    </div>
</body>

</html>