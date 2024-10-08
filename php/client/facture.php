<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client</title>
    <script src="../../js/pokemon.js" defer></script>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link href="../../css/style_profil.css" rel="stylesheet">
</head>

<?php include_once('../../include/header.php'); ?>
<script>
    $("#pokemon").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>

<br>
<main class="main">
<div class="contenair d-flex"> 
<aside class="flex-grow-1">
    <div class="bg-light border rounded-3 p-1 h-100 sticky-top">
        <ul class="nav nav-pills flex-sm-column flex-row mb-auto justify-content-between text-truncate">
            <li class="my-1">
                <a href="compte_client.php" class="nav-link px-2 text-truncate">
                    <i class="bi bi-layout-text-sidebar-reverse"></i>
                    <span class="d-none d-sm-inline">Mon profil</span>
                </a>
            </li>
            <li class="my-1 nav-item">
                <a href="commande.php" class="nav-link px-2 text-truncate"><i class="bi bi-card-text fs-5"></i>
                    <span class="d-none d-sm-inline">Commandes</span> </a>
            </li>
            <li class="my-1">
                <a href="politique.php" class="nav-link px-2 text-truncate"><i class="bi bi-people fs-5"></i>
                    <span class="d-none d-sm-inline">Politiques</span> </a>
        </li>
        </ul>
    </div>
</aside>

<main class="flex-grow-4">
<main class="col overflow-auto h-100 w-100">
    <a class="btn btn-dark btn-sm" href="commande.php">← Retour</a><br><br>
    <div class="container py-2">

<?php
// Récupérer l'ID de la commande via GET
$id_commande = $_GET['id']; 

// URL de l'API pour récupérer les informations de la commande
$commande_api_url = "http://127.0.0.1:8000/api/commandes/{$id_commande}/";
$curl = curl_init($commande_api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$commande_response = curl_exec($curl);

// Vérifier s'il y a des erreurs cURL
if(curl_errno($curl)) {
    echo 'Erreur cURL : ' . curl_error($curl);
} else {
    $commande = json_decode($commande_response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'Erreur lors du décodage JSON : ' . json_last_error_msg();
    } else {
        // Affichage des informations de la commande
        echo "<h1>Facture Pokedex</h1>";
        echo "<p>Commande n° : ".$commande['numero_commande']."</p>";
        echo "<p>Date : ".$commande['date_creation']."</p>";
        echo "<p>Client : ".$commande['utilisateur']."</p>"; // Récupérer les informations de l'utilisateur si besoin
        echo "<p>Livraison : ".ucfirst($commande['adresse_livraison'])."</p>";
        echo "<p>Total : ".round($commande['total'], 2)." €</p>";
    }
}
curl_close($curl);
?>

<form><input id="impression" name="impression" type="button" onclick="imprimer_page()" value="Imprimer cette page" /></form>

<table class="table table-striped table-hover">
<thead>
    <!-- Tableau affichant les différentes informations -->
    <tr>
        <th>Article</th>
        <th>Nom du Pokémon</th>
        <th>Prix unitaire</th>
        <th>Quantité</th>
        <th>Total</th>
    </tr>
</thead>
<tbody>
<?php
// Maintenant on récupère les détails de la commande
// Les détails sont contenus directement dans l'API de la commande
$details = $commande['details'] ?? [];

if (empty($details)) {
    echo "<tr><td colspan='5'>Aucun article trouvé pour cette commande.</td></tr>";
} else {
    foreach ($details as $detail) {
        $pokemon_id = $detail['produit'];
        $quantite = $detail['quantite'];

        // On va maintenant récupérer les informations de chaque Pokémon via l'API Pokedex
        $pokemon_api_url = "http://127.0.0.1:8000/api/pokedex/{$pokemon_id}/";
        $curl = curl_init($pokemon_api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $pokemon_response = curl_exec($curl);
        $pokemon = json_decode($pokemon_response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "<tr><td colspan='5'>Erreur de décodage JSON pour le Pokémon ID : {$pokemon_id}</td></tr>";
        } else {
            $prix_unitaire = number_format($pokemon['prix'] * (1 - $pokemon['discount'] / 100), 2);
            $total = number_format($prix_unitaire * $quantite, 2);
            echo "<tr>";
            echo "<td><img src='../" . htmlspecialchars($pokemon['image']) . "' width='100'></td>";
            echo "<td>" . htmlspecialchars($pokemon['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($prix_unitaire) . " €</td>";
            echo "<td>" . htmlspecialchars($quantite) . "</td>";
            echo "<td>" . htmlspecialchars($total) . " €</td>";
            echo "</tr>";
        }
        curl_close($curl);
    }
}
?>
</tbody>
</table>
</div>
</main>
</div>
</div>

<script type="text/javascript">
function imprimer_page() {
    window.print();
}
</script>
