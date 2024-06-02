<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tout Parcourir - Agora Francia</title>
    <style> 
        * {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    line-height: 1.6;
}

.wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

header {
    background-color: #003f5c;
    color: white;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h1 {
    margin: 0;
    font-size: 1.5rem;
}

.logo {
    max-width: 100%;
    max-height: 3rem;
}

nav {
    background-color: #2f4f4f;
    padding: 0.5rem;
    display: flex;
    justify-content: space-around;
}

nav ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
}

nav li {
    margin: 0 0.5rem;
}

nav a {
    color: white;
    text-decoration: none;
    padding: 0.5rem;
    display: block;
}

nav a:hover {
    background-color: #003f5c;
}

section {
    padding: 2rem;
    flex-grow: 1;
}

h2 {
    margin-top: 0;
}

.article {
    background-color: #f4f4f4;
    padding: 1rem;
    margin-bottom: 1rem;
    display: flex;
    flex-wrap: wrap;
}

.article-img {
    max-width: 100%;
    height: auto;
    margin-right: 1rem;
}

.article p {
    margin: 0;
    flex-basis: 100%;
}

.bid-button,
.buy-button {
    background-color: #003f5c;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    margin-top: 0.5rem;
}

.bid-button:hover,
.buy-button:hover {
    background-color: #2f4f4f;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #f4f4f4;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
}

.close-button {
    color: #003f5c;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.submit-button {
    background-color: #003f5c;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    margin-top: 0.5rem;
}

.submit-button:hover {
    background-color: #2f4f4f;
}

footer {
    background-color: #2f4f4f;
    color: white;
    padding: 1rem;
    text-align: center;
    flex-shrink: 0;
}
</style>
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
                <li><a href="votre_compte.php">Votre compte</a></li>
                <li><a href="login.php">Se Connecter</a></li>
            </ul>
        </nav>
        <section>
            <h2>Meilleure Offre</h2>
            <div class="article">

           <?php
            // Connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "agorafrancia";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Récupération des données de la table "item"
            $sql = "SELECT ID, Nom, Prix, prix_actuel, Photo, fin_enchere FROM item WHERE type_vente = 'enchere' AND expired = 0";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="article">';
                    echo '<img src="' . $row["Photo"] . '" alt="' . $row["Nom"] . '" class="article-img">';
                    echo '<p>' . $row["Nom"] . '</p>';
                    echo '<p>Prix initial : ' . $row["Prix"] . ' €</p>';
                    echo '<p>Prix actuel : ' . $row["prix_actuel"] . ' €</p>';
                    
                    $fin_enchere = new DateTime($row["fin_enchere"]);
                    $maintenant = new DateTime();
                    $diff = $fin_enchere->getTimestamp() - $maintenant->getTimestamp();
                    echo '<p>Temps restant : <span class="timer" data-timer="' . $diff . '" data-article-id="' . $row["ID"] . '"></span></p>';

                    echo '<button class="bid-button" onclick="openBidForm(' . $row["ID"] . ')">Enchérir</button>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun article aux enchères pour le moment.</p>';
            }

            $conn->close();
            ?>

            </div>
            <div id="bidForm" class="modal">
                <div class="modal-content">
                    <span class="close-button" onclick="closeBidForm()">&times;</span>
                    <h2>Enchérir</h2>
                    <form id="bidFormContent" action="submit_bid.php" method="post">
                        <label for="bidValue">Entrez votre offre:</label>
                        <input type="number" id="bidValue" name="bidValue" min="1" required>
                        <input type="hidden" id="articleId" name="articleId">
                        <button type="submit" class="submit-button">Soumettre</button>
                    </form>
                </div>
            </div>

            <h2>Vente Directe</h2>
             <?php
            // Connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "agorafrancia";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Sélectionner les articles de vente directe non expirés
            $sql = "SELECT ID, Nom, prix_actuel, Photo FROM item WHERE type_vente = 'vente_directe' AND expired = 0";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="article">';
                    echo '<img src="' . $row["Photo"] . '" alt="' . $row["Nom"] . '" class="article-img">';
                    echo '<p>' . $row["Nom"] . '</p>';
                    echo '<p>Prix: ' . $row["prix_actuel"] . ' €</p>';
                    echo '<button class="buy-button" onclick="addToCart(' . $row["ID"] . ', \'vente_directe\')">Acheter</button>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun article en vente directe pour le moment.</p>';
            }

            $conn->close();
            ?>
        </section>
        <footer>
            <p>Contact: <a href="mailto:info@agorafrancia.fr">info@agorafrancia.fr</a></p>
            <p>&copy; 2024 Agora Francia</p>
        </footer>
    </div>

    <script>
function openBidForm(articleId) {
    document.getElementById('bidForm').style.display = 'block';
    document.getElementById('articleId').value = articleId;
}

function closeBidForm() {
    document.getElementById('bidForm').style.display = 'none';
    // Recharger la page pour mettre à jour les prix des enchères
    window.location.reload(true);
}

document.getElementById('bidFormContent').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);

    fetch('submit_bid.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Vérifier si la réponse est un nombre valide
        if (!isNaN(parseFloat(data))) {
            // Mettre à jour la variable contenant le prix aux enchères
            var newPrice = parseFloat(data);

            alert('Votre offre a été soumise pour ' + document.getElementById('articleId').value + ' avec une valeur de ' + document.getElementById('bidValue').value + '€');
            closeBidForm();
        } else {
            // Afficher un message d'erreur si la réponse n'est pas un nombre valide
            alert('Erreur: Veuillez entrer une offre valide.');
        }
    })
    .catch(error => console.error('Erreur:', error));
});

function buyNow(articleId) {
    fetch('buy_now.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'articleId=' + articleId
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        window.location.reload();
    })
    .catch(error => console.error('Erreur:', error));
}

function addToCart(articleId, typeVente) {
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'articleId=' + articleId + '&typeVente=' + typeVente + '&userId=1' // Remplacez 1 par l'ID de l'utilisateur connecté
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        window.location.reload();
    })
    .catch(error => console.error('Erreur:', error));
}

function updateTimer() {
    // Récupérer tous les éléments contenant le timer
    var timers = document.querySelectorAll('.timer');

    // Pour chaque élément timer, mettre à jour le temps restant
    timers.forEach(function(timerElement) {
        // Récupérer le temps restant de l'attribut data-timer
        var remainingTime = parseInt(timerElement.getAttribute('data-timer'));

        // Vérifier si le temps restant est supérieur à zéro
        if (remainingTime > 0) {
            // Calculer les heures, minutes et secondes restantes
            var hours = Math.floor(remainingTime / 3600);
            var minutes = Math.floor((remainingTime % 3600) / 60);
            var seconds = remainingTime % 60;

            // Formater le temps en HH:MM:SS
            var formattedTime = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            // Mettre à jour le texte de l'élément timer avec le nouveau temps
            timerElement.textContent = formattedTime;

            // Décrémenter le temps restant de 1 seconde
            remainingTime--;

            // Mettre à jour l'attribut data-timer avec le nouveau temps restant
            timerElement.setAttribute('data-timer', remainingTime);
        } else {
            // Si le temps est écoulé, afficher "Expiré" et mettre à jour la base de données
            timerElement.textContent = 'Expiré';
            var articleId = timerElement.getAttribute('data-article-id');

            addToCartOnExpire(articleId);

            // Envoyer une requête AJAX pour mettre à jour la base de données
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_expired_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('articleId=' + articleId);
        }
    });
}


// Appeler la fonction updateTimer toutes les secondes
setInterval(updateTimer, 1000);


// Vérifier les enchères expirées toutes les 30 secondes
setInterval(updateExpiredAuctions, 1000);

function addToCartOnExpire(articleId) {
    console.log('Tentative d\'ajout de l\'article expiré au panier, ID:', articleId);
    fetch('add_to_cart_on_expire.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'articleId=' + articleId
    })
    .then(response => response.text())
    .then(data => {
        console.log('Réponse de add_to_cart_on_expire:', data);
        window.location.reload();
    })
    .catch(error => console.error('Erreur:', error));
}



    </script>
</body>
</html>
