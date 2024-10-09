<?php
session_start();

// Récupérer l'ID de l'utilisateur connecté
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$user_id) {
    echo json_encode(['error' => 'Utilisateur non connecté.']);
    exit();
}

// Récupérer l'ID du produit via la requête GET
$produit_id = isset($_GET['produit_id']) ? intval($_GET['produit_id']) : null;

if (!$produit_id) {
    echo json_encode(['error' => 'Produit non spécifié.']);
    exit();
}

// Appel API pour récupérer les commandes de l'utilisateur
$api_url = "http://127.0.0.1:8000/api/utilisateurs/$user_id/commandes/";
$curl = curl_init($api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Exécuter la requête
$response = curl_exec($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// Vérifier si la requête a été un succès
if ($httpcode === 200) {
    $commandes = json_decode($response, true);
    $a_achete_produit = false;

    // Parcourir les commandes pour voir si l'utilisateur a acheté le produit
    foreach ($commandes as $commande) {
        foreach ($commande['details'] as $detail) {
            if ($detail['produit'] == $produit_id) {
                $a_achete_produit = true;
                break 2;  // On arrête la boucle si le produit est trouvé
            }
        }
    }

    if ($a_achete_produit) {
        echo json_encode(['success' => true, 'achat' => true, 'message' => 'L\'utilisateur a déjà acheté ce produit.']);
    } else {
        echo json_encode(['success' => true, 'achat' => false, 'message' => 'L\'utilisateur n\'a pas acheté ce produit.']);
    }
} else {
    // Si la requête API échoue
    echo json_encode(['error' => 'Erreur lors de la récupération des commandes.']);
}

curl_close($curl);
?>
