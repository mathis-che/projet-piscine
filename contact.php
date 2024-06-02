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
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <link rel="icon" type="image/png" href="../image/logo.jpg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia</title>
    <link rel="stylesheet" href="../css/principale.css">
    <link rel="stylesheet" href="../css/guillaume.css">
    
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
        <div id="perspective">
        <div id="container">
            <div class="face front">
                <div id="white">
                    <h1>Contactez-nous!<br><span>--------</span></h1>
                </div>
            </div>
            <div class="face back">
                <div id="open"></div>
                <div id="folds"></div>
                <div class="button con">formulaire de contact</div>
                <div id="letter">
                    <hgroup>
                        <h1 id="info">Dérouler</h1>
                        <h2></h2>
                    </hgroup>
                    <p>

                    <form>
                        <span class="Email">
                            <input for="email" type="email" name="email" id="email" size="40" class="emailinput"
                                aria-required="true" aria-invalid="false" placeholder="Email" required>
                        </span>

                        <span class="Name">
                            <input for="sujet" type="text" name="sujet" id="sujet" value="" size="40" class="nameinput"
                                aria-required="true" aria-invalid="false" placeholder="Sujet" required>
                        </span>

                        <span class="Message">
                            <textarea for="message" name="message" id="message" cols="40" rows="10" aria-invalid="false"
                                placeholder="Message" required></textarea>
                        </span>

                        <input type="submit" value="Envoyer" class="button send">
                    </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div id="wrapper"></div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var C = $('#container'),
            A = $('#open'),
            L = $('#letter'),
            B = $('.button.con'),
            H = $('#letter hgroup h2'),
            F = $('.front'),
            W = $('#wrapper'),
            P = $('#perspective'),
            closed = true;
        $(function () {
            $("textarea").text("");
        });

        F.click(function () {
            C.css({
                'transition': 'all 1s',
                'transform': 'rotateY(180deg)',
            });
            A.css({
                'transition': 'all 1s .5s',
                'transform': 'rotateX(180deg)',
                'z-index': '0'
            });
            W.css({
                'visibility': 'visible'
            });
        });
        W.click(function () {
            var message = $.trim($('textarea').val());
            if (message.length > 0) {
                var r = confirm("Vous n’avez pas envoyé votre message, souhaitez-vous toujours fermer le formulaire?");
                if (r == false) {
                    return;
                }
                else {
                    document.getElementById("myform").reset();
                }
            }
            if (closed === false) {
                L.css({
                    'transition': 'all .7s',
                    'top': '3px',
                    'height': '200px'
                });
                P.css({
                    'transform': 'translateY(0px)'
                });
                F.css({
                    'transform': 'rotateZ(0deg)'
                });
                H.css({
                    'transition': 'all .5s',
                    'transform': 'rotateZ(0deg)'
                });
                C.css({
                    'transition': 'all 1.2s .95s'
                });
                A.css({
                    'transition': 'all 1.2s .7s'
                });
                H.css({
                    'transition': 'all .5s'
                });
                document.getElementById("info").innerHTML = "Dérouler";
                closed = true;
            }
            else {
                C.css({
                    'transition': 'all 1s .5s',
                });
                A.css({
                    'transition': 'all .5s',
                });
                closed = false;
            }
            C.css({
                'transform': 'rotateY(0deg) rotate(3deg)'
            });
            A.css({
                'transform': 'rotateX(0deg)',
                'z-index': '10'
            });
            W.css({
                'visibility': 'hidden'
            });
        });
        B.click(function () {

            L.css({
                'transition': 'all .5s 1s',
                'top': '-600px',
                'height': '550px'
            });
            P.css({
                'transition': 'all 1s',
                'transform': 'translateY(450px)'
            });
            H.css({
                'transition': 'all 1s',
                'transform': 'rotateZ(180deg)'
            });
            document.getElementById("info").innerHTML = "Contactez-nous";
        });

        $(document).ready(function () {
            $('#success-alert').hide();
            <?php if (!empty($success_message)) : ?>
                $('#success-alert').show();
            <?php endif; ?>
        });
    </script>
        </section>
    </div>
</body>
</html>
