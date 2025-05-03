<?php
include('../includes/db.php');

// Vérifier si l'ID de la commande est passé en paramètre
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Supprimer d'abord les détails de la commande dans la table `details_commandes`
    $queryDetails = "DELETE FROM details_commandes WHERE commande_id = $id";
    $resultDetails = mysqli_query($conn, $queryDetails);

    // Vérifier si la suppression des détails a réussi
    if ($resultDetails) {
        // Supprimer ensuite la commande dans la table `commandes`
        $query = "DELETE FROM commandes WHERE id = $id";
        $result = mysqli_query($conn, $query);

        // Vérification de la suppression de la commande
        if ($result) {
            // Rediriger vers la page de gestion des commandes avec un message de succès
            header('Location: gestion_commandes.php?message=Commande supprimée avec succès');
            exit;
        } else {
            // Afficher l'erreur SQL si la suppression de la commande échoue
            echo "Erreur lors de la suppression de la commande. Erreur SQL: " . mysqli_error($conn);
        }
    } else {
        // Si la suppression des détails échoue, afficher l'erreur
        echo "Erreur lors de la suppression des détails de la commande. Erreur SQL: " . mysqli_error($conn);
    }
} else {
    // Si l'ID n'est pas présent dans l'URL, rediriger vers la page de gestion des commandes
    header('Location: gestion_commandes.php');
    exit;
}
?>
