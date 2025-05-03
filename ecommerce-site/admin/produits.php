<?php
include('../includes/header_admin.php');
include('../includes/db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$queryAdmin = "SELECT is_admin FROM utilisateurs WHERE id = " . $_SESSION['user_id'];
$resultAdmin = mysqli_query($conn, $queryAdmin);
$isAdmin = mysqli_fetch_assoc($resultAdmin)['is_admin'];

if ($isAdmin != 1) {
    echo "<p style='color:red;'>Accès refusé. Cette page est réservée aux administrateurs.</p>";
    exit();
}

// Ajouter un produit
if (isset($_POST['ajouterProduit'])) {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = mysqli_real_escape_string($conn, $_POST['prix']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $categorie_id = mysqli_real_escape_string($conn, $_POST['categorie_id']);

    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../image/';
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
    }

    $query = "INSERT INTO produits (nom, prix, stock, description, categorie_id, image) 
              VALUES ('$nom', '$prix', '$stock', '$description', '$categorie_id', '$image_name')";
    mysqli_query($conn, $query);
}

// Modifier un produit
if (isset($_POST['modifierProduit'])) {
    $id = $_POST['id'];
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = mysqli_real_escape_string($conn, $_POST['prix']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $categorie_id = mysqli_real_escape_string($conn, $_POST['categorie_id']);

    $image_sql = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../image/';
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
        $image_sql = ", image = '$image_name'";
    }

    $query = "UPDATE produits 
              SET nom = '$nom', prix = '$prix', stock = '$stock', description = '$description', categorie_id = '$categorie_id' $image_sql 
              WHERE id = $id";
    mysqli_query($conn, $query);
}

// Supprimer un produit
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    mysqli_query($conn, "DELETE FROM produits WHERE id = $id");
}

// Récupérer produits + nom catégorie
$queryProduits = "SELECT p.*, c.nom AS categorie_nom FROM produits p
                  JOIN categories c ON p.categorie_id = c.id";
$resultProduits = mysqli_query($conn, $queryProduits);

// Catégories pour les <select>
$queryCategories = "SELECT * FROM categories";
$resultCategories = mysqli_query($conn, $queryCategories);
?>

<main>
    <h2>Gestion des Produits</h2>

    <!-- Ajouter un produit -->
    <h3>Ajouter un produit</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="number" step="0.01" name="prix" placeholder="Prix" required>
        <input type="number" name="stock" placeholder="Stock" min="0" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <select name="categorie_id" required>
            <option value="">Choisir une catégorie</option>
            <?php while ($cat = mysqli_fetch_assoc($resultCategories)) : ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['nom'] ?></option>
            <?php endwhile; ?>
        </select>
        <input type="file" name="image" accept="image/*">
        <button type="submit" name="ajouterProduit">Ajouter</button>
    </form>

    <!-- Liste des produits -->
    <h3>Liste des produits</h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Catégorie</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Recharger les catégories pour le deuxième while
            mysqli_data_seek($resultCategories, 0); 
            while ($row = mysqli_fetch_assoc($resultProduits)) : ?>
                <tr>
                    <td><?= $row['nom'] ?></td>
                    <td><?= number_format($row['prix'], 2, ',', ' ') ?> €</td>
                    <td><?= $row['stock'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['categorie_nom'] ?></td>
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="../image/<?= $row['image'] ?>" width="80" alt="image produit">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Formulaire de modification -->
                        <form method="POST" enctype="multipart/form-data" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="text" name="nom" value="<?= $row['nom'] ?>" required>
                            <input type="number" step="0.01" name="prix" value="<?= $row['prix'] ?>" required>
                            <input type="number" name="stock" value="<?= $row['stock'] ?>" required>
                            <textarea name="description" required><?= $row['description'] ?></textarea>
                            <select name="categorie_id" required>
                                <option value="<?= $row['categorie_id'] ?>" selected><?= $row['categorie_nom'] ?></option>
                                <?php
                                mysqli_data_seek($resultCategories, 0);
                                while ($cat = mysqli_fetch_assoc($resultCategories)) :
                                    if ($cat['id'] != $row['categorie_id']) :
                                ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['nom'] ?></option>
                                <?php endif; endwhile; ?>
                            </select>
                            <input type="file" name="image" accept="image/*">
                            <button type="submit" name="modifierProduit">Modifier</button>
                        </form>
                        <a href="?supprimer=<?= $row['id'] ?>" onclick="return confirm('Supprimer ce produit ?')" style="color:red;">Supprimer</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include('../includes/footer.php'); ?>
