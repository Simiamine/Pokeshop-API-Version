<?php
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

$data = json_decode(file_get_contents('php://input')); // Convertir les données JSON en objet PHP

if ($data) { // Vérifier si les données JSON ont été correctement décodées
    // Vérifier si le produit existe déjà dans le panier
    $produit_existe = false;
    foreach ($_SESSION['panier'] as $index => $produit) {
        if ($produit->pokemon_id == $data->pokemon_id) {
            // Mettre à jour la quantité du produit existant
            $_SESSION['panier'][$index]->quantite += 1;
            $produit_existe = true;
            break;
        }
    }
    
    // Si le produit n'existe pas dans le panier, l'ajouter avec une quantité initiale de 1
    if (!$produit_existe) {
        // Ajouter la propriété "quantite" avec une valeur initiale de 1
        $data->quantite = 1;
        array_push($_SESSION['panier'], $data);
    }

    // Calculer le nombre total d'articles dans le panier
    $totalArticles = 0;
    foreach ($_SESSION['panier'] as $produit) {
        $totalArticles += $produit->quantite;
    }

    // Retourner le nombre d'articles sous forme de JSON
    echo json_encode([
        'message' => 'Produit ajouté au panier avec succès',
        'totalArticles' => $totalArticles
    ]);
} else {
    echo json_encode(['error' => 'Erreur : les données du produit ne sont pas valides.']);
}
?>
