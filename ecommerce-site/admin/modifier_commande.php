<?php
include('../includes/db.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $id = (int) $_POST['id'];
    $statut = mysqli_real_escape_string($conn, $_POST['statut']);

    // Requête de mise à jour du statut de la commande
    $query = "UPDATE commandes SET statut = '$statut' WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // Vérification de la requête
    if ($result) {
        // Rediriger vers la page de gestion des commandes avec un message de succès
        header('Location: gestion_commandes.php?message=Statut mis à jour avec succès');
        exit;
    } else {
        echo "Erreur lors de la mise à jour du statut de la commande.";
    }
}
?>
