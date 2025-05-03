<?php
include('includes/db.php');
include('includes/header.php');

// Initialiser les filtres
$nom = isset($_GET['nom']) ? mysqli_real_escape_string($conn, $_GET['nom']) : '';
$prix_max = isset($_GET['prix_max']) && is_numeric($_GET['prix_max']) ? (float) $_GET['prix_max'] : null;
$categorie_id = isset($_GET['categorie_id']) && is_numeric($_GET['categorie_id']) ? (int) $_GET['categorie_id'] : 0;

// Début de la requête SQL de base
$query = "SELECT p.*, c.nom AS categorie_nom 
          FROM produits p
          LEFT JOIN categories c ON p.categorie_id = c.id 
          WHERE p.stock > 0"; // Condition de base : produits en stock

// Liste des conditions à ajouter
$conditions = [];

// Ajouter des conditions dynamiques
if (!empty($nom)) {
    $conditions[] = "p.nom LIKE '%$nom%'";
}

if (!is_null($prix_max)) {
    $conditions[] = "p.prix <= $prix_max";
}

if ($categorie_id !== 0) {
    $conditions[] = "p.categorie_id = $categorie_id";
}

// Si des conditions sont présentes, les ajouter à la requête
if (count($conditions) > 0) {
    $query .= " AND " . implode(" AND ", $conditions);
}

// Ajouter la clause ORDER BY
$query .= " ORDER BY p.id DESC";

// Exécution de la requête SQL
$result = mysqli_query($conn, $query);

// Vérification des erreurs dans la requête
if (!$result) {
    die("Erreur dans la requête SQL : " . mysqli_error($conn));
}

// Récupérer les catégories pour la liste déroulante
$categories = mysqli_query($conn, "SELECT * FROM categories");
?>

<main class="container">
    <h1>Recherche de pièces détachées</h1>

    <!-- Formulaire de recherche -->
    <form method="GET" style="margin-bottom: 20px;">
        <input type="text" name="nom" placeholder="Nom du produit" value="<?= htmlspecialchars($nom) ?>">
        <input type="number" name="prix_max" placeholder="Prix max" step="0.01" value="<?= htmlspecialchars($prix_max) ?>">
        <select name="categorie_id">
            <option value="0">Toutes les catégories</option>
            <?php while ($cat = mysqli_fetch_assoc($categories)) : ?>
                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $categorie_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nom']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Rechercher</button>
    </form>

    <!-- Résultats -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table border="0" cellpadding="10" cellspacing="0">
            <tr>
                <?php
                $i = 0;
                while ($product = mysqli_fetch_assoc($result)) {
                    if ($i > 0 && $i % 3 == 0) {
                        echo "</tr><tr>";
                    }
                ?>
                    <td style="text-align: center; vertical-align: top; border: 1px solid #ccc;">
                        <img src="image/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['nom']) ?>" width="100"><br>
                        <h3><?= htmlspecialchars($product['nom']) ?></h3>
                        <p><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...</p>
                        <p><strong>Prix : <?= number_format($product['prix'], 3, ',', ' ') ?> DT</strong></p>
                        <p>Catégorie : <?= htmlspecialchars($product['categorie_nom']) ?></p>
                        <a href="produit.php?id=<?= $product['id'] ?>">Voir le produit</a>
                    </td>
                <?php
                    $i++;
                }
                ?>
            </tr>
        </table>

        
    <?php else: ?>
        <p>Aucun produit trouvé selon vos critères.</p>
    <?php endif; ?>
</main>

<?php include('includes/footer.php'); ?>
