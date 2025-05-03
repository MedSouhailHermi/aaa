<?php
include('../includes/db.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Tableau de bord</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header style="background-color: #2c3e50; color: white; padding: 15px;">
    <div class="container">
        <h1>Admin - Gestion du site</h1>
        <nav>
            <ul style="list-style: none; display: flex; gap: 20px; padding: 0;">
                <li><a href="/ecommerce-site/admin/dashboard.php" style="color: white;">Dashboard</a></li>
                <li><a href="/ecommerce-site/admin/produits.php" style="color: white;">Produits</a></li>
                <li><a href="/ecommerce-site/admin/commandes.php" style="color: white;">Commandes</a></li>
                <li><a href="/ecommerce-site/admin/utilisateurs.php" style="color: white;">Utilisateurs</a></li>
                <li><a href="../auth/logout.php" style="color: red;">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
</header>
<main class="container">
