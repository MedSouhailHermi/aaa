<?php
session_start();
include('includes/db.php');
include('includes/header.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour voir votre historique.";
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM commandes WHERE utilisateur_id = '$user_id' ORDER BY date_commande DESC";
$result = mysqli_query($conn, $query);
?>

<h1>Historique de mes commandes</h1>
<table>
    <tr>
        <th>Commande</th>
        <th>Date</th>
        <th>Statut</th>
        <th>Total</th>
    </tr>
    <?php
    while ($order = mysqli_fetch_assoc($result)) {
        $commande_id = $order['id'];
        $query_details = "SELECT SUM(prix_unitaire * quantite) AS total FROM details_commandes WHERE commande_id = '$commande_id'";
        $result_details = mysqli_query($conn, $query_details);
        $details = mysqli_fetch_assoc($result_details);
        $total = $details['total'];

        echo "<tr>
                <td><a href='commande_details.php?id=$commande_id'>#{$order['id']}</a></td>
                <td>{$order['date_commande']}</td>
                <td>{$order['statut']}</td>
                <td>" . number_format($total, 2, ',', ' ') . "€</td>
              </tr>";
    }
    ?>
</table>


