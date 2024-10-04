<?php
session_start();

// Stocker les informations de l'utilisateur dans la session
if ($_POST['access_token'] && $_POST['user_id']) {
    $_SESSION['access_token'] = $_POST['access_token'];
    $_SESSION['user_id'] = $_POST['user_id'];
    $_SESSION['prenom'] = $_POST['prenom'];
    $_SESSION['nom'] = $_POST['nom'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['statut'] = $_POST['statut'];
}
?>