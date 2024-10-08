<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/catalogue.js"></script>
    <title>Ma Collection Pokémon</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<?php include_once('../include/header.php'); ?>
<script>
    $("#pokedex").addClass("active");  // Ajoute une classe active au menu Pokedex
</script>

<body>  
<div class="cards-container">
<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['access_token']) || !isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour voir votre collection.</p>";
    exit;
}

// Récupérer l'ID de l'utilisateur et le token d'accès
$accessToken = $_SESSION['access_token'];
$userId = $_SESSION['user_id'];

// Récupérer les commandes de l'utilisateur via l'API
$commandeApiUrl = "http://127.0.0.1:8000/api/utilisateurs/{$userId}/commandes/";
$curl = curl_init($commandeApiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
]);
$response = curl_exec($curl);

// Vérifier les erreurs de cURL
if(curl_errno($curl)) {
    echo 'Erreur cURL : ' . curl_error($curl);
    exit;
}
$commandes = json_decode($response, true);
curl_close($curl);

if (!empty($commandes)) {
    // Stocker tous les Pokémon de toutes les commandes
    $pokemonsInCollection = [];

    // Récupérer chaque détail de commande (Pokémon)
    foreach ($commandes as $commande) {
        if (isset($commande['details'])) {
            foreach ($commande['details'] as $detail) {
                $pokemonId = $detail['produit'];
                $quantite = $detail['quantite'];

                // Si le Pokémon existe déjà dans la collection, on augmente sa quantité
                if (isset($pokemonsInCollection[$pokemonId])) {
                    $pokemonsInCollection[$pokemonId]['quantite'] += $quantite;
                } else {
                    // Récupérer les détails du Pokémon via l'API Pokedex
                    $pokemonApiUrl = "http://127.0.0.1:8000/api/pokedex/{$pokemonId}/";
                    $curl = curl_init($pokemonApiUrl);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $pokemonResponse = curl_exec($curl);
                    curl_close($curl);

                    $pokemonData = json_decode($pokemonResponse, true);
                    if (!empty($pokemonData)) {
                        $pokemonData['quantite'] = $quantite; // Ajouter la quantité pour la première fois
                        $pokemonsInCollection[$pokemonId] = $pokemonData;
                    }
                }
            }
        }
    }

    // Fonction pour obtenir la couleur en fonction du type
    function getPokemonBgColor($type) {
        $colors = [
            'Normal' => '#929da3',
            'Combat' => '#cf406b',
            'Vol' => '#8fa8df',
            'Poison' => '#ab6ac8',
            'Sol' => '#d97944',
            'Roche' => '#c5b68d',
            'Insecte' => '#91c12f',
            'Spectre' => '#5268ac',
            'Acier' => '#5b8ea3',
            'Feu' => '#fe9d54',
            'Eau' => '#5190d7',
            'Plante' => '#63bc5a',
            'Électrique' => '#f5d33c',
            'Psy' => '#f85888',
            'Glace' => '#74cec0',
            'Dragon' => '#0c69c8',
            'Ténèbres' => '#5a5366',
            'Fée' => '#f1a8ec'
        ];

        return isset($colors[$type]) ? $colors[$type] : '#929da3'; // couleur par défaut
    }

    // Afficher les cartes des Pokémon dans la collection
    foreach ($pokemonsInCollection as $pokemon) {
        $bg_color_1 = getPokemonBgColor($pokemon['type_1']);
        $bg_color_2 = !empty($pokemon['type_2']) ? getPokemonBgColor($pokemon['type_2']) : $bg_color_1;
        $bg_gradient = ($pokemon['type_2']) ? "background: linear-gradient(135deg, $bg_color_1, $bg_color_2);" : "background-color: $bg_color_1;";

        echo '<div class="card" style="width: 18rem; ' . $bg_gradient . ';">';
        echo '<div class="card-img-top-container" style="position: relative;">';
        echo '<img src="../img/' . htmlspecialchars($pokemon['image']) . '" class="card-img-top" alt="Image de ' . htmlspecialchars($pokemon['nom']) . '">';

        // Ajouter l'affichage de la quantité si supérieure à 1
        if ($pokemon['quantite'] > 1) {
            echo '<span class="quantite-badge">x' . htmlspecialchars($pokemon['quantite']) . '</span>';
        }

        echo '</div>';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($pokemon['nom']) . '</h5>';
        echo '<p class="card-text">';
        echo '<strong>Type 1 :</strong> ' . htmlspecialchars($pokemon['type_1']);
        if (!empty($pokemon['type_2'])) {
            echo '<br><strong>Type 2 :</strong> ' . htmlspecialchars($pokemon['type_2']);
        }
        echo '<br><strong>Génération :</strong> ' . htmlspecialchars($pokemon['generation']);
        echo '<br><strong>Légendaire :</strong> ' . ($pokemon['legendaire'] ? 'Oui' : 'Non');
        echo '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<p>Vous n'avez encore capturé aucun Pokémon.</p>";
}
?>
</div>

<style>
/* Styles CSS pour le catalogue */
.cards-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-evenly; 
  align-items: center;
  margin-right: 10%;
  margin-left: 9%;
}

.card {
  box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  border-radius: 9px;
  overflow: hidden;
  margin: 2rem;
  flex-basis: 20%;
  max-width: 20%;
  cursor: pointer;
}

.card:hover {
  box-shadow: 0 8px 20px 0 rgba(0, 0, 0, 0.2);
}

.card-img-top-container {
  padding: 2.6rem;
  background-color: white; 
}

.card-img-top {
  width: 100%;
  object-fit: contain;
}

.card-body {
  padding: 3rem;
}

.card-title {
  font-size: 1.5rem;
}

.card-text {
  font-size: 1rem;
  color: #757575;
}

.pokemon-type {
  display: block;
}

.search-wrap {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    width: 70%;
    padding: 10px;
    background-color: #f5f5f5;
    margin-left: auto;
    margin-right: auto;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.search-input {
    flex-grow: 1;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}

.search-btn {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px;
    margin-left: 5px;
    cursor: pointer;
}

.filters {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 20px 0;
}

.filter-select {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.popup {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: rgba(0,0,0,0.5);
    display: none; 
    justify-content: center; 
    align-items: center; 
    z-index: 1000;
}

.popup-content {
    margin: auto;
    background: white;
    width: 70%; 
    padding: 6%; 
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    position: relative; 
    margin-top: 13%;
    border-radius: 9px;
}

.close {
    position: absolute;
    top: 10px;
    right: 20px;
    cursor: pointer;
    font-size: 25px;
}

.popup-flex-container {
    display: flex;
    align-items: flex-start;
    gap: 20px;
}

.popup-text-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
}

.popup-text-content h3, .popup-text-content div, .button-ajouter {
    margin-bottom: 15px;
}

.popup-content img {
    flex: 0.5;
    max-width: 300px; /* Limite la largeur de l'image */
    max-height: 300px; /* Limite la hauteur de l'image */
    width: auto; /* Conserve le ratio de l'image */
    height: auto; /* Conserve le ratio de l'image */
    margin: 0 auto; /* Centre l'image horizontalement */
    display: block; /* Assure que l'image soit centrée */
}

#pokemonDescription {
    font-size: 16px;
    margin: 10px 0;
    text-align: justify;
    max-width: 100%;
}

.button-ajouter {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.button-ajouter:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .popup-flex-container {
        flex-direction: column;
        align-items: center;
    }

    .popup-content {
        width: 80%;
    }
}

.quantite-badge {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background-color: rgba(0, 0, 0, 0.7); /* Fond semi-transparent pour la lisibilité */
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 1.2rem;
    font-weight: bold;
}
</style>
</body>
</html>