<?php
session_start();
include('../includes/db.php');
include('../includes/header.php');

// Vérifier si le panier existe déjà
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Ajouter un produit au panier
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $query = "SELECT * FROM produits WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    // Vérifier s'il y a déjà le produit dans le panier
    $product_in_cart = false;
    foreach ($_SESSION['panier'] as $key => $value) {
        if ($value['id'] == $product['id']) {
            $_SESSION['panier'][$key]['quantite'] += 1; // Incrémenter la quantité
            $product_in_cart = true;
            break;
        }
    }

    // Si le produit n'est pas dans le panier, l'ajouter
    if (!$product_in_cart) {
        $_SESSION['panier'][] = array(
            'id' => $product['id'],
            'nom' => $product['nom'],
            'prix' => $product['prix'],
            'quantite' => 1
        );
    }
}

// Afficher le panier
?>

<h1>Mon Panier</h1>
<table>
    <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Prix</th>
        <th>Total</th>
        <th>Actions</th>
    </tr>
    <?php
    $total = 0;
    foreach ($_SESSION['panier'] as $item) {
        $total += $item['prix'] * $item['quantite'];
        echo "<tr>
                <td>{$item['nom']}</td>
                <td>{$item['quantite']}</td>
                <td>" . number_format($item['prix'], 2, ',', ' ') . "€</td>
                <td>" . number_format($item['prix'] * $item['quantite'], 2, ',', ' ') . "€</td>
                <td><a href='panier.php?remove={$item['id']}'>Supprimer</a></td>
              </tr>";
    }
    ?>
</table>
<h2>Total : <?php echo number_format($total, 2, ',', ' ') . '€'; ?></h2>

<?php
// Supprimer un produit du panier
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    foreach ($_SESSION['panier'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['panier'][$key]);
            break;
        }
    }
    header('Location: panier.php');
}
?>

<a href="/ecommerce-site/commande/commander.php">Passer à la commande</a>

<?php include('../includes/footer.php'); ?>
