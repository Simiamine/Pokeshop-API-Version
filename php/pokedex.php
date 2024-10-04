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
    <title>Pokedex</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<?php include_once('../include/header.php'); ?>
<script>
    $("#pokedex").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>

<body>  

<div class="cards-container">
<?php
// Vérification de la présence du token d'accès dans la session
if (!isset($_SESSION['access_token'])) {
    echo "<p>Vous devez être connecté pour voir vos commandes.</p>";
    exit; // Stoppe l'exécution du script si l'utilisateur n'est pas connecté
}

// Récupérer le token d'accès depuis la session
$accessToken = $_SESSION['access_token'];

// Récupérer les commandes de l'utilisateur via l'API
$ch = curl_init('http://127.0.0.1:8000/api/utilisateurs/'.$_SESSION['user_id'].'/commandes/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $commandes = json_decode($response, true);
    
    if (!empty($commandes)) {
        $pokedex = [];
        // Parcourir les commandes et récupérer les Pokémon dans le champ 'details'
        foreach ($commandes as $commande) {
            if (isset($commande['details']) && is_array($commande['details'])) {
                foreach ($commande['details'] as $detail) {
                    $pokedex[] = $detail['produit_nom'];  // Assumption that 'produit_nom' is the name of the Pokémon
                }
            }
        }
        
        // Rendre les IDs uniques pour éviter les doublons
        $pokedex = array_unique($pokedex);
        
        // Pour chaque Pokémon, récupérer ses informations via l'API
        foreach ($pokedex as $pokemonName) {
            $pokemonApiUrl = 'http://127.0.0.1:8000/api/pokedex/?nom=' . urlencode($pokemonName);
            $ch = curl_init($pokemonApiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ]);

            $pokemonResponse = curl_exec($ch);
            curl_close($ch);
            $pokemonData = json_decode($pokemonResponse, true);

            if (!empty($pokemonData)) {
                $pokemon = $pokemonData[0];  // Assuming the API returns an array of one Pokémon

                // Affichage des cartes pour chaque Pokémon
                echo '<div class="card">' .
                     '<div class="card-img-top-container">' .
                     '<img src="' . htmlspecialchars($pokemon['image'], ENT_QUOTES) . '" alt="Image de ' . htmlspecialchars($pokemon['nom'], ENT_QUOTES) . '" class="card-img-top">' .
                     '</div>' .
                     '<div class="card-body">' .
                     '<h5 class="card-title">' . htmlspecialchars($pokemon['nom'], ENT_QUOTES) . '</h5>' .
                     '<p class="card-text">' .
                     '<strong>Type principal:</strong> ' . htmlspecialchars($pokemon['type_1'], ENT_QUOTES) .
                     (empty($pokemon['type_2']) ? '' : ', <strong>Type secondaire:</strong> ' . htmlspecialchars($pokemon['type_2'], ENT_QUOTES)) .
                     '<br><strong>Génération:</strong> ' . htmlspecialchars($pokemon['generation'], ENT_QUOTES) .
                     '<br><strong>Légendaire:</strong> ' . ($pokemon['legendaire'] ? 'Oui' : 'Non') .
                     '</p>' .
                     '</div>' .
                     '</div>';
            } else {
                echo "<p>Impossible de récupérer les détails pour le Pokémon : " . htmlspecialchars($pokemonName) . "</p>";
            }
        }
    } else {
        echo "<p>Aucune commande passée.</p>";
    }
} else {
    echo "<p>Erreur lors de la récupération des commandes. Veuillez réessayer plus tard.</p>";
}
?>
</body>
<style>

 
#pokemonName {
    position: absolute; 
    top: 0; 
    left: 50%; 
    transform: translateX(-50%); /* Centre le nom horizontalement par rapport à sa propre largeur */
    font-size: 60px; 
    margin-top: 20px; 
}

.popup-content img {
    flex: 0.5; 
}


#pokemonDescription {
    font-size: 16px;
    margin: 10px 0; /* Espacement autour de la description */
    text-align: justify; /* Alignement du texte pour une lecture facile */
    max-width: 100%; /* Assure que le texte ne dépasse pas du conteneur */
}

     /*style pour la barre de recherche */ 


     /*style pour le contenue du pokemon */ 
     .cards-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center; /* Center the cards */
  align-items: center; /* Align cards to the top */
  margin-right: 10%;
  margin-left: 9%;
}

.card {
  box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  border-radius: 9px;
  overflow: hidden;
  margin: 2rem;
  flex-basis: calc(25% - 4rem); /* Make each card 25% width minus margins */
  max-width: calc(25% - 4rem); /* Make sure the max width matches */
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

@media (max-width: 991px) {
  .card {
    flex-basis: calc(45% - 4rem); /* Sur les tablettes, deux cartes par ligne */
    max-width: calc(45% - 4rem);
  }
}

@media (max-width: 767px) {
  .card {
    flex-basis: calc(90% - 4rem); /* Sur les mobiles, une carte par ligne */
    max-width: calc(90% - 4rem);
  }
}

</style>
