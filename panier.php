<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier - Agora Francia</title>
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

.delete-button {
    background-color: #ff4d4d;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    margin-top: 0.5rem;
}

.delete-button:hover {
    background-color: #ff1a1a;
}


.validate-cart-button {
    background-color: #003f5c;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    margin-top: 1rem;
}

.validate-cart-button:hover {
    background-color: #2f4f4f;
}

/* Modal styles */
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
    margin: 10% auto 0; /* Réduire la marge supérieure */
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
}


modal-content form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

.close-button {
    color: #003f5c;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close-button:hover,
.close-button:focus {
    color: #000;
    text-decoration: none;
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
            <h2>Votre Panier</h2>
            <div class="panier-items">
                <?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "agorafrancia";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les articles du panier de l'utilisateur actuel
session_start();
$user_id = 1; // Remplacez cette ligne par : $user_id = $_SESSION['user_id'];

// Supprimer un article du panier et réinitialiser son statut d'expiration
if (isset($_POST['delete'])) {
    $item_id = $_POST['item_id'];
    $delete_sql = "DELETE FROM panier WHERE user_id = $user_id AND article_id = $item_id";
    if ($conn->query($delete_sql) === TRUE) {
        // Mettre à jour le statut d'expiration de l'article pour le rendre disponible
        $update_sql = "UPDATE item SET expired = 0 WHERE ID = $item_id";
        $conn->query($update_sql);
    }
}

// Récupérer les articles du panier
$sql = "SELECT item.ID, item.Nom, item.Photo, panier.prix
        FROM panier
        JOIN item ON panier.article_id = item.ID
        WHERE panier.user_id = $user_id";
$result = $conn->query($sql);

$total_prix = 0;

// Afficher les articles dans le panier
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="panier-item">';
        echo '<img src="' . $row["Photo"] . '" alt="' . $row["Nom"] . '" class="item-img">';
        echo '<p>' . $row["Nom"] . '</p>';
        echo '<p>Prix: ' . $row["prix"] . ' €</p>';
        echo '<form method="post" action="panier.php">';
        echo '<input type="hidden" name="item_id" value="' . $row["ID"] . '">';
        echo '<button type="submit" name="delete" class="delete-button">Supprimer</button>';
        echo '</form>';
        echo '</div>';
        $total_prix += $row["prix"];
    }
    echo '<div class="total-prix">';
    echo '<p>Total: ' . $total_prix . ' €</p>';
    echo '</div>';
} else {
    echo '<p>Votre panier est vide.</p>';
}

// Fermer la connexion à la base de données
$conn->close();
?>
<button class="validate-cart-button">Valider le panier</button>
            </div>
        </section>
        <footer>
            <p>Contact: <a href="mailto:info@agorafrancia.fr">info@agorafrancia.fr</a></p>
            <p>&copy; 2024 Agora Francia</p>
        </footer>
    </div>

    <!-- Modal pour le formulaire de paiement -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Formulaire de paiement</h2>
            <form id="paymentForm" action="traiter_paiement.php" method="post">
                <label for="cardType">Type de carte :</label><br>
<select id="cardType" name="cardType">
    <option value="visa">Visa</option>
    <option value="mastercard">MasterCard</option>
    <option value="amex">American Express</option>
    <option value="paypal">PayPal</option>
</select><br><br>

<label for="cardNumber">Numéro de carte :</label><br>
<input type="text" id="cardNumber" name="cardNumber"><br><br>

<label for="cardName">Nom sur la carte :</label><br>
<input type="text" id="cardName" name="cardName"><br><br>

<label for="expiryDate">Date d'expiration de la carte :</label><br>
<input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY"><br><br>

<label for="cvv">Code de sécurité (CVV) :</label><br>
<input type="text" id="cvv" name="cvv"><br><br>
<button type="button" class="submit-button">Valider le paiement</button>
                </div>

                
            </form>
        </div>
    </div>

    <script>
        // JavaScript pour la modal et la logique de formulaire
        document.querySelector(".validate-cart-button").addEventListener("click", function() {
            document.getElementById("paymentModal").style.display = "block";
        });

        document.querySelector(".close-button").addEventListener("click", function() {
            document.getElementById("paymentModal").style.display = "none";
        });

        document.querySelector(".submit-button").addEventListener("click", function() {
        document.getElementById("paymentForm").submit();
        });

        window.addEventListener("click", function(event) {
            if (event.target == document.getElementById("paymentModal")) {
                document.getElementById("paymentModal").style.display = "none";
            }
        });

        document.getElementById("creditCard").addEventListener("change", function() {
            if (this.checked) {
                document.getElementById("creditCardInfo").style.display = "block";
            }
        });
    </script>

</body>
</html>
