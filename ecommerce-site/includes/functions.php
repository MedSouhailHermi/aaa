<?php
// Fonction pour sécuriser les données d'entrée
function cleanInput($data) {
    return htmlspecialchars(trim($data));
}

// Fonction pour vérifier si un utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fonction pour sécuriser une requête SQL
function prepareQuery($conn, $query, $params) {
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, ...$params);
    return $stmt;
}
?>
