<?php
include('../includes/db.php');
include('../includes/header_admin.php');

// Récupérer toutes les commandes
$query = "SELECT * FROM commandes";
$result = mysqli_query($conn, $query);
?>

<h1>Gestion des commandes</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Utilisateur</th>
        <th>Date</th>
        <th>Statut</th>
        <th>Actions</th>
    </tr>
    <?php while ($order = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $order['id']; ?></td>
        <td><?php echo $order['utilisateur_id']; ?></td>
        <td><?php echo $order['date_commande']; ?></td>
        
        <!-- Formulaire pour modifier le statut de la commande -->
        <td>
            <form action="./modifier_commande.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                <select name="statut" onchange="this.form.submit()">
                    <option value="en attente" <?php echo ($order['statut'] == 'en attente') ? 'selected' : ''; ?>>En attente</option>
                    <option value="sous traitement" <?php echo ($order['statut'] == 'sous traitement') ? 'selected' : ''; ?>>Sous traitement</option>
                    <option value="livré" <?php echo ($order['statut'] == 'livré') ? 'selected' : ''; ?>>Livré</option>
                </select>
            </form>
        </td>

        <td>
            <a href="supprimer_commande.php?id=<?php echo $order['id']; ?>">Supprimer</a>
        </td>
    </tr>
    <?php } ?>
</table>

