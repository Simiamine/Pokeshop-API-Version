<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie que les informations utilisateur essentielles sont bien envoyées dans la requête
    if (isset($_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['statut'], $_POST['access_token'], $_POST['user_id'])) {
        // Enregistrement des informations utilisateur dans la session
        $_SESSION['user_prenom'] = $_POST['prenom'];
        $_SESSION['user_nom'] = $_POST['nom'];
        $_SESSION['user_email'] = $_POST['email'];
        $_SESSION['user_statut'] = $_POST['statut'];

        // Enregistrement du token et de l'ID utilisateur dans la session
        $_SESSION['access_token'] = $_POST['access_token'];
        $_SESSION['user_id'] = $_POST['user_id'];

        // Ajout d'une date d'expiration pour les tokens (facultatif)
        $_SESSION['token_expiration'] = time() + (60 * 60); // Expire dans 1 heure

        // Autres informations utilisateur à stocker si nécessaire (ajoutées selon ton besoin)
        if (isset($_POST['telephone'])) {
            $_SESSION['user_telephone'] = $_POST['telephone'];
        }

        if (isset($_POST['date_naissance'])) {
            $_SESSION['user_date_naissance'] = $_POST['date_naissance'];
        }

        // Retourner un message de succès si toutes les informations sont bien enregistrées
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Les informations utilisateur ne sont pas complètes."]);
    }
}
?>
