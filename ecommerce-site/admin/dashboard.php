<?php
// Démarrer la session si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérification de l'authentification administrateur
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Connexion à la base de données
include('../includes/db.php');
include('../includes/header_admin.php');

// Vérifier si l'utilisateur est admin
$queryAdmin = "SELECT is_admin FROM utilisateurs WHERE id = " . $_SESSION['user_id'];
$resultAdmin = mysqli_query($conn, $queryAdmin);
$isAdmin = mysqli_fetch_assoc($resultAdmin)['is_admin'];

if ($isAdmin != 1) {
    echo "<p style='color:red;'>Accès refusé. Cette page est réservée aux administrateurs.</p>";
    include('../includes/footer.php');
    exit();
}

// Récupérer les statistiques
$queryProduits = "SELECT COUNT(*) AS totalProduits FROM produits";
$queryCommandes = "SELECT COUNT(*) AS totalCommandes FROM commandes";

$resultProduits = mysqli_query($conn, $queryProduits);
$resultCommandes = mysqli_query($conn, $queryCommandes);

$rowProduits = mysqli_fetch_assoc($resultProduits);
$rowCommandes = mysqli_fetch_assoc($resultCommandes);
?>

<main class="container">
    <h2>Tableau de Bord - Administrateur</h2>

    <div class="stats">
        <div class="stat-card">
            <h3>Total des Produits</h3>
            <p><?= $rowProduits['totalProduits'] ?></p>
        </div>
        <div class="stat-card">
            <h3>Total des Commandes</h3>
            <p><?= $rowCommandes['totalCommandes'] ?></p>
        </div>
    </div>

    <div class="admin-links">
        <h3>Gestion du Site</h3>
        <ul>
            <li><a href="produits.php">🛠 Gestion des Produits</a></li>
            <li><a href="commandes.php">📦 Gestion des Commandes</a></li>
            <li><a href="utilisateurs.php">👤 Gestion des Utilisateurs</a></li>
        </ul>
    </div>
</main>

<?php include('../includes/footer.php'); ?>
