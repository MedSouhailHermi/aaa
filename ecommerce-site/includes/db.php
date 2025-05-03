<?php
$servername = "localhost";
$username = "root"; // Par défaut sur WAMP/XAMPP
$password = "";
$dbname = "ecommerce";

// Connexion à la base de données
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
