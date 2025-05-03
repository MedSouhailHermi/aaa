<?php
// Inclure la connexion à la base de données et le header
include('includes/db.php');
include('includes/header.php');

// Requête pour récupérer tous les produits
$query = "SELECT * FROM produits";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erreur de requête : " . mysqli_error($conn));
}
?>

<h1>Gestion des produits</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prix</th>
        <th>Stock</th>
        <th>Image</th>
    </tr>
    <?php while ($product = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $product['id']; ?></td>
        <td><?php echo $product['nom']; ?></td>
        <td><?php echo number_format($product['prix'], 2, ',', ' ') . '€'; ?></td>
        <td><?php echo $product['stock']; ?></td>
        <td><img src="image/<?php echo $product['image']; ?>" alt="<?php echo $product['nom']; ?>" width="200" height="200"></td>

    </tr>
    <?php } ?>
</table>

<?php
// Inclure le footer
?>
