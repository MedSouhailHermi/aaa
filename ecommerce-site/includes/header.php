<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site e-commerce</title>
    <link rel="stylesheet" href="/ecommerce-site/css/style.css"> <!-- Chemin absolu -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/ecommerce-site/accueil.php">Accueil</a></li>
                <li><a href="/ecommerce-site/produits.php">Produits</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/ecommerce-site/historique.php">Historique</a></li>
                    <li><a href="/ecommerce-site/auth/logout.php">Se déconnecter</a></li>
                <?php else: ?>
                    <li><a href="/ecommerce-site/auth/login.php">Se connecter</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
