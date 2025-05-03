<?php
include('../includes/db.php');
include('../includes/header_admin.php');

$query = "SELECT * FROM utilisateurs where is_admin = 0";
$result = mysqli_query($conn, $query);
?>

<h1>Gestion des utilisateurs</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Email</th>
    </tr>
    <?php while ($user = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['nom']; ?></td>
        <td><?php echo $user['email']; ?></td>

    </tr>
    <?php } ?>
</table>

<?php include('../includes/footer.php'); ?>
