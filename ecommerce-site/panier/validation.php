<?php
session_start();
include('../includes/db.php');
include('../includes/header.php');

// Vérifier si le panier est vide
if (empty($_SESSION['panier'])) {
    echo "<p>Votre panier est vide. Ajoutez des produits pour passer une commande.</p>";
    exit;
}

// Si l'utilisateur est connecté, il peut procéder à la validation
if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour passer une commande. <a href='../auth/login.php'>Se connecter</a></p>";
    exit;
}

// Récupérer les informations de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM utilisateurs WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Traitement du formulaire de validation de commande
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adresse = $_POST['adresse'];
    
    // Ajouter la commande dans la table des commandes
    $query = "INSERT INTO commandes (utilisateur_id, adresse_livraison, date_commande, statut_
