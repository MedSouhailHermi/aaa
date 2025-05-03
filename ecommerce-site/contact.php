<?php
include('includes/db.php');
include('includes/header.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Sécurisation des données
    $nom = mysqli_real_escape_string($conn, $nom);
    $email = mysqli_real_escape_string($conn, $email);
    $message = mysqli_real_escape_string($conn, $message);

    // Envoi du message par email (optionnel, à configurer selon le serveur)
    $to = "contact@monsite.com"; // L'adresse e-mail du destinataire
    $subject = "Nouveau message de contact";
    $body = "Nom : $nom\nEmail : $email\nMessage :\n$message";
    $headers = "From: $email";

    // Vérification et envoi de l'email
    if (mail($to, $subject, $body, $headers)) {
        echo "<p>Votre message a été envoyé avec succès !</p>";
    } else {
        echo "<p>Erreur lors de l'envoi de votre message. Veuillez réessayer plus tard.</p>";
    }
}
?>

<!-- Formulaire de contact -->
<form method="POST" action="">
    <input type="text" name="nom" placeholder="Votre nom" required>
    <input type="email" name="email" placeholder="Votre email" required>
    <textarea name="message" placeholder="Votre message" required></textarea>
    <button type="submit">Envoyer</button>
</form>

<!-- Bouton retour -->
<button onclick="window.location.href='accueil.php'">Retour à l'accueil</button>

<?php include('includes/footer.php'); ?>
