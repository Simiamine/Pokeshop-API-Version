<?php
// Démarrer la session
session_start();
include '../include/databaseconnect.php'; // Pour se connecter a la bdd

// Assurez-vous que l'utilisateur est connecté et que son ID est stocké dans la session
if (!isset($_SESSION['user_id'])) {
    die("Utilisateur non connecté");
}

// Récupérer l'ID de l'utilisateur actuel
$user_id = $_SESSION['user_id'];

// Informations de connexion à la base de données


    // Préparer et exécuter la requête SQL pour mettre à jour l'abonnement
$sql = "UPDATE utilisateur SET abonnement = 1 WHERE id = :id";
$stmt = $bdd->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "Votre abonnement a été activé avec succès.";
} else {
    echo "Erreur lors de l'activation de l'abonnement.";
}

?>

