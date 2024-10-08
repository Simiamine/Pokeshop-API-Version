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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<?php include_once('../include/header.php'); ?>
<script>
    $("#catalogue").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>

<body>  
<div class="search-wrap">
    <input type="text" id="search-input" class="search-input" placeholder="Rechercher un pokemon">
    <button class="search-btn"><i class="fa-solid fa-search fa-lg"></i></button>
</div>

<div class="filters">
    <select id="type-filter" class="filter-select">
        <option value="">Tous les types</option>
        <option value="Normal">Normal</option>
        <option value="Combat">Combat</option>
        <option value="Vol">Vol</option>
        <option value="Poison">Poison</option>
        <option value="Sol">Sol</option>
        <option value="Roche">Roche</option>
        <option value="Insecte">Insecte</option>
        <option value="Spectre">Spectre</option>
        <option value="Acier">Acier</option>
        <option value="Feu">Feu</option>
        <option value="Eau">Eau</option>
        <option value="Plante">Plante</option>
        <option value="Électrique">Électrique</option>
        <option value="Psy">Psy</option>
        <option value="Glace">Glace</option>
        <option value="Dragon">Dragon</option>
        <option value="Ténèbres">Ténèbres</option>
        <option value="Fée">Fée</option>
    </select>

    <select id="legendaire-filter" class="filter-select">
        <option value="">Légendaire/Non légendaire</option>
        <option value="Oui">Légendaire</option>
        <option value="Non">Non légendaire</option>
    </select>
</div>

<div class="cards-container">
<?php
// URL de l'API Django
$api_url = 'http://127.0.0.1:8000/api/pokedex/';

// Initialisation de cURL
$curl = curl_init($api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Exécution de la requête
$response = curl_exec($curl);

// Vérification des erreurs de cURL
if(curl_errno($curl)) {
    echo 'Erreur cURL : ' . curl_error($curl);
} else {
    // Décodage du JSON reçu de l'API
    $pokemons = json_decode($response, true);

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

    // Parcourir chaque Pokémon récupéré de l'API
    foreach ($pokemons as $pokemon) {
        $bg_color_1 = getPokemonBgColor($pokemon['type_1']);
        $bg_color_2 = !empty($pokemon['type_2']) ? getPokemonBgColor($pokemon['type_2']) : $bg_color_1;

        // Utilisation d'un dégradé si le Pokémon a deux types
        $bg_gradient = ($pokemon['type_2']) ? "background: linear-gradient(135deg, $bg_color_1, $bg_color_2);" : "background-color: $bg_color_1;";

        // Vérifier si la clé 'légendaire' existe avant de l'utiliser
        $legendaire = $pokemon['legendaire'] ? 'Oui' : 'Non';  // Remplace 'légendaire' par 'legendaire'
        // Vérifier si la clé 'quantité' existe avant de l'utiliser
        $quantite = isset($pokemon['quantité']) ? $pokemon['quantité'] : 'Non défini';
?>
<div class="card" style="width: 18rem; <?php echo $bg_gradient; ?>"
    data-id="<?php echo $pokemon['id']; ?>" 
    data-name="<?php echo $pokemon['nom']; ?>" 
    data-image="../img/<?php echo $pokemon['image']; ?>" 
    data-description="<?php echo $pokemon['description']; ?>"
    data-type="<?php echo $pokemon['type_1']; ?>"
    data-type2="<?php echo $pokemon['type_2']; ?>"
    data-generation="<?php echo $pokemon['generation']; ?>"
    data-legendaire="<?php echo $pokemon['legendaire'] ? 'Oui' : 'Non'; ?>"  
    data-quantite="<?php echo $quantite; ?>"   
>
    <div class="card-img-top-container">
        <img src="../img/<?php echo $pokemon['image']; ?>" class="card-img-top" alt="Image du pokemon">
    </div>
    <div class="card-body">
        <h5 class="card-title"><?php echo $pokemon['nom']; ?></h5>
        <p class="card-text">
            <span class="pokemon-type"><?php echo $pokemon['type_1']; ?></span>
            <span class="pokemon-type"><?php echo $pokemon['type_2']; ?></span>
        </p>
        <?php
        $prixOriginal = floatval($pokemon['prix']);
        $remise = floatval($pokemon['discount']);

        // Vérifie si une remise est appliquée
        if ($remise > 0) {
            $prixApresRemise = $prixOriginal - ($prixOriginal * ($remise / 100));
        ?>
            <p class="card-text">
                Prix Original: <span class="original-price"><?php echo number_format($prixOriginal, 2, '.', ''); ?>€</span>
            </p>
            <div class="card-footer">
                Prix remise: 
                <span class="discounted-price"><?php echo number_format($prixApresRemise, 2, '.', ''); ?>€</span>
            </div>
        <?php
        } else {
        ?>
            <p class="card-text">
                Prix: <span class="price"><?php echo number_format($prixOriginal, 2, '.', ''); ?>€</span>
            </p>
        <?php
        }
        ?>
    </div>
</div>
<?php
    }
}
// Fermeture de cURL
curl_close($curl);
?>
</div>

<div id="pokemonPopup" class="popup" style="display: none;">
    <div class="popup-content">
        <span class="close">&times;</span>
        <div class="popup-flex-container">
            <img id="pokemonImage" src="" alt="Image du Pokemon" />
            <div class="popup-text-content">
                <h3 id="pokemonName"></h3>
                <div>Pokémon ID: <span id="pokemonID"></span></div>
                <div><strong>Génération : </strong><span id="generation" class="pokemon-generation"></span></div>
                <div><strong>Légendaire : </strong><span id="legendaire" class="pokemon-legendaire"></span></div>
                <div><strong>Description : </strong><span id="pokemonDescription"></span></div>
                <div><strong>Prix Initial : </strong><span id="initialPrice" class="pokemon-price"></span></div>
                <div><strong>Prix après Remise : </strong><span id="discountedPrice" class="pokemon-discounted-price"></span></div>
                <div><span id="quantite"></span></div>
                <button type="button" class="button-ajouter">Ajouter au Panier</button>
            </div>
        </div>
    </div>
</div>

<script>
// Barre de recherche et filtres
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('search-input');
    const typeFilter = document.getElementById('type-filter');
    const legendaireFilter = document.getElementById('legendaire-filter');
    const cards = document.querySelectorAll('.card');
    const noResultsDiv = document.getElementById('no-results');

    function filterCards() {
        const searchText = searchInput.value.toLowerCase();
        const selectedType = typeFilter.value.toLowerCase();
        const selectedLegendaire = legendaireFilter.value.toLowerCase();
        let found = false;

        cards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const type1 = card.getAttribute('data-type').toLowerCase();
            const type2 = card.getAttribute('data-type2').toLowerCase();
            const legendaire = card.getAttribute('data-legendaire').toLowerCase();

            const matchesSearch = name.startsWith(searchText);
            const matchesType = selectedType === '' || type1 === selectedType || type2 === selectedType;
            const matchesLegendaire = selectedLegendaire === '' || legendaire === selectedLegendaire;

            if (matchesSearch && matchesType && matchesLegendaire) {
                card.style.display = '';
                found = true;
            } else {
                card.style.display = 'none';
            }
        });

        noResultsDiv ? noResultsDiv.style.display = found ? 'none' : 'block' : null;
    }

    searchInput.addEventListener('input', filterCards);
    typeFilter.addEventListener('change', filterCards);
    legendaireFilter.addEventListener('change', filterCards);
});

// Gestion de la pop-up
document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.card');
    const popup = document.getElementById('pokemonPopup');
    const popupName = document.getElementById('pokemonName');
    const popupImage = document.getElementById('pokemonImage');
    const popupDescription = document.getElementById('pokemonDescription');
    const quantite = document.getElementById('quantite');
    const closePopup = document.querySelector('.popup .close');
    const popupId = document.getElementById('pokemonID');

    function openPopup(id, name, image, description, generation, legendaire, quantite, price, discountedPrice) {
        popupId.textContent = id;
        popupName.textContent = name;
        popupImage.src = image;
        popupDescription.textContent = description;
        document.getElementById('generation').textContent = generation;
        document.getElementById('legendaire').textContent = legendaire === 'Oui' ? 'Oui' : 'Non';
        if (quantite <= 0) {
            document.getElementById('quantite').innerHTML = "<span style='color: red; font-size: 1.5em;'>Victime de son succès</span>";
            document.querySelector('.button-ajouter').style.display = 'none';
        } else {
            document.querySelector('.button-ajouter').style.display = 'block';
            if (quantite < 5) {
                document.getElementById('quantite').innerHTML = `<span style="font-size: 1.5em;">Attention, il ne reste plus que <span style="color: red;">${quantite}</span> Pokémon !</span>`;
            } else {
                document.getElementById('quantite').textContent = '';
            }
        }

        document.getElementById('initialPrice').textContent = price;
        document.getElementById('discountedPrice').textContent = discountedPrice;
        popup.style.display = 'block';
    }

    cards.forEach(card => {
        card.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const image = this.getAttribute('data-image');
            const description = this.getAttribute('data-description');
            const generation = this.getAttribute('data-generation');
            const legendaire = this.getAttribute('data-legendaire');
            const quantite = this.getAttribute('data-quantite');
            const priceElement = this.querySelector('.price') || this.querySelector('.original-price');
            const discountedPriceElement = this.querySelector('.discounted-price');
        
            const price = priceElement ? priceElement.textContent : 'N/A';
            const discountedPrice = discountedPriceElement ? discountedPriceElement.textContent : priceElement.textContent;

            openPopup(id, name, image, description, generation, legendaire, quantite, price, discountedPrice);
        });
    });

    // Gestionnaire de clic pour fermer la pop-up
    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    // Ajouter au panier
    document.querySelector('.button-ajouter').addEventListener('click', function() {
        const name = document.getElementById('pokemonName').textContent;
        const price = document.getElementById('initialPrice').textContent;
        const discountedPrice = document.getElementById('discountedPrice').textContent;
        const ID = document.getElementById('pokemonID').textContent;

        const produit = {
            nom: name,
            prix: price,
            prixApresRemise: discountedPrice,
            pokemon_id: ID
        };

        fetch('ajouter_au_panier.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(produit)
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Erreur lors de l\'ajout au panier:', error);
        });

        alert("Votre Pokémon a été ajouté au panier");
        location.reload();
    });
});
</script>

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
</style>
</body>
</html>
