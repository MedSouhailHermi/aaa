<?php
session_start();
include('../includes/db.php');
include('../includes/header.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour passer une commande.";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);
    $user_id = $_SESSION['user_id'];

    // Créer la commande dans la base de données
    $query = "INSERT INTO commandes (utilisateur_id, adresse_livraison) VALUES ('$user_id', '$adresse')";
    $res = mysqli_query($conn, $query) or die("Erreur insertion commande : " . mysqli_error($conn));

    $commande_id = mysqli_insert_id($conn);

    // Ajouter les produits du panier
    foreach ($_SESSION['panier'] as $item) {
        $produit_id = $item['id'];
        $quantite = $item['quantite'];
        $prix = $item['prix'];

        $query = "INSERT INTO details_commandes (commande_id, produit_id, quantite, prix_unitaire) 
                  VALUES ('$commande_id', '$produit_id', '$quantite', '$prix')";
        mysqli_query($conn, $query) or die("Erreur insertion détails : " . mysqli_error($conn));
    }

    // Vider le panier
    unset($_SESSION['panier']);

    echo "<h2>✅ Commande réussie ! Merci pour votre achat.</h2>";

    // Facultatif : redirection après 5 secondes
    // header("refresh:5;url=../index.php");
    // exit;
}
?>

<!-- Formulaire de livraison -->
<form method="POST" action="">
    <label for="adresse">Adresse de livraison :</label><br>
    <textarea name="adresse" id="adresse" rows="4" cols="50" placeholder="Saisissez votre adresse" required></textarea><br><br>
    <button type="submit">Confirmer la commande</button>
</form>

<?php include('../includes/footer.php'); ?>
