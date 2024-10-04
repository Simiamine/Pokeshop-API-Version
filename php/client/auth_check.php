<?php
session_start();

// Vérifier si un access_token est présent
if (!isset($_SESSION['access_token']) || !isset($_SESSION['user_statut'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: /login.php');
    exit();
}

// Vérification du statut
if ($_SESSION['user_statut'] == 'client') {
    // Redirection vers le compte client si c'est un client
    header('Location: /client/compte_client.php');
} elseif ($_SESSION['user_statut'] == 'admin') {
    // Redirection vers le tableau de bord admin si c'est un admin
    header('Location: /admin/dashboard.php');
} else {
    // Gestion des cas où le rôle est inconnu
    echo "Rôle utilisateur inconnu.";
    exit();
}
?>
