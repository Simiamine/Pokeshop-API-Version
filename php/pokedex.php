<?php
session_start();
require '../include/databaseconnect.php';
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
    <link rel="stylesheet" href="../css/style.css">
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
// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour voir vos commandes.</p>";
    exit; // Stoppe l'exécution du script si l'utilisateur n'est pas connecté
}

// Utilisation de l'ID de l'utilisateur connecté pour filtrer les commandes
$userId = $_SESSION['user_id'];

$sql = "SELECT lc.pokemon
        FROM ligne_commandes lc
        JOIN commandes c ON lc.id_commande = c.id
        WHERE c.id_utilisateur = :userId"; 
        
$requete = $bdd->prepare($sql);
$requete->bindParam(':userId', $userId, PDO::PARAM_INT);
$requete->execute();
$pokedex = array();  // Liste vide qui va contenir les id des pokemons

while ($ligne_commandes = $requete->fetch(PDO::FETCH_ASSOC)) {
    $pokemonJson = $ligne_commandes['pokemon'];
    $pokemon = json_decode($pokemonJson, true);

    // Vérifier que la conversion a réussi
    if (json_last_error() === JSON_ERROR_NONE && is_array($pokemon)) {
        foreach ($pokemon as $cle => $val) {
            $pokedex[] = $cle;
        }
    } else {
        // Afficher un message d'erreur détaillé
        echo "ERREUR DE CONVERSION JSON : " . json_last_error_msg();
        echo " - Valeur de pokemon : " . htmlspecialchars($pokemonJson);
    }
}

$pokedex = array_unique($pokedex);  // Enleve les doublons des id de pokemon

foreach ($pokedex as $idPok) {
    $sql = "SELECT p.nom as nom_pokemon, p.type_1, p.type_2, p.generation, p.légendaire, p.prix, p.discount, p.image, p.description
            FROM pokedex p WHERE p.id = :idPok";
    $requete = $bdd->prepare($sql);
    $requete->bindParam(':idPok', $idPok, PDO::PARAM_INT);
    $requete->execute();
    // Récupérer le résultat
    $ligne_commandes = $requete->fetch(PDO::FETCH_ASSOC);
    echo '<div class="card">' .
         '<div class="card-img-top-container">' .
         '<img src="' . htmlspecialchars($ligne_commandes['image'], ENT_QUOTES) . '" alt="Image de ' . htmlspecialchars($ligne_commandes['nom_pokemon'], ENT_QUOTES) . '" class="card-img-top">' .
         '</div>' .
         '<div class="card-body">' .
         '<h5 class="card-title">' . htmlspecialchars($ligne_commandes['nom_pokemon'], ENT_QUOTES) . '</h5>' .
         '<p class="card-text">' .
         '<strong>Type principal:</strong> ' . htmlspecialchars($ligne_commandes['type_1'], ENT_QUOTES) .
         (empty($ligne_commandes['type_2']) ? '' : ', <strong>Type secondaire:</strong> ' . htmlspecialchars($ligne_commandes['type_2'], ENT_QUOTES)) .
         '<br><strong>Génération:</strong> ' . htmlspecialchars($ligne_commandes['generation'], ENT_QUOTES) .
         '<br><strong>Légendaire:</strong> ' . ($ligne_commandes['légendaire'] ? 'Oui' : 'Non') .

         '</p>' .
         '</div>' .
         '</div>';
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
