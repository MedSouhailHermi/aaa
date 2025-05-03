<?php
include('../includes/db.php');

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Requête SQL pour vérifier l'utilisateur
    $query = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erreur de requête : " . mysqli_error($conn));
    }

    $user = mysqli_fetch_assoc($result);

    // Vérification des identifiants
    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Connexion réussie, création de la session
        $_SESSION['user_id'] = $user['id'];

        // Vérifier si l'utilisateur est administrateur
        if ($user['is_admin'] == 1) {
            // Si administrateur, rediriger vers le tableau de bord admin
            header('Location: ../admin/dashboard.php');
        } else {
            // Si non administrateur, rediriger vers la page d'accueil
            header('Location: ../accueil.php');
        }
        exit(); // N'oublie pas d'ajouter exit pour arrêter l'exécution du script après la redirection
    } else {
        echo "<p style='color: red;'>Identifiants incorrects. Veuillez réessayer.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter - Site e-commerce</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Se connecter</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" placeholder="Votre email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Votre mot de passe" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
        
        <p>Pas encore de compte ? <a href="../auth/register.php">S'inscrire</a></p>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
