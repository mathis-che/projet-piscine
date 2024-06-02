// Function to place a bid
function placeBid(productId) {
    var bidAmount = prompt("Entrez le montant de votre enchère:");
    if (bidAmount != null && bidAmount.trim() != "") {
        // Send bid to server using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "place_bid.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle response from server
                if (xhr.responseText === "success") {
                    // Reload the page to update bid information
                    location.reload();
                } else {
                    alert("Erreur lors de la soumission de l'enchère.");
                }
            }
        };
        xhr.send("product_id=" + productId + "&bid_amount=" + bidAmount);
    }
}
