<?php
include('includes/db.php');
include('includes/header.php');

$product_id = $_GET['id'];
$query = "SELECT * FROM produits WHERE id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
?>

<div class="container">
    <h1><?php echo $product['nom']; ?></h1>
    <img src="image/<?php echo $product['image']; ?>" alt="<?php echo $product['nom']; ?>" width="200" height="200">
    <p><?php echo $product['description']; ?></p>
    <p>Prix : <?php echo number_format($product['prix'], 2, ',', ' ') . '€'; ?></p>
    <p>Stock : <?php echo $product['stock']; ?></p>
    <a href="panier/panier.php?id=<?php echo $product['id']; ?>">Ajouter au panier</a>
</div>

