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
    $("#catalogue").addClass("active");  // Fonction pour mettre la     class "active" en fonction de la page
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
    <select id="legendary-filter" class="filter-select">
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
        $quantite = isset($pokemon['quantite']) ? $pokemon['quantite'] : 'Non défini';
?>
<div class="card" style="width: 18rem; <?php echo $bg_gradient; ?>; "
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
        <p class="card-text">Quantité disponible: <span class="quantite-disponible"><?php echo $quantite; ?></span></p>

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
                <div><strong>Description : </strong><span id="pokemonDescription"></span></div>
                <div><strong>Prix Initial : </strong><span id="initialPrice" class="pokemon-price"></span></div>
                <div><strong>Prix après Remise : </strong><span id="discountedPrice" class="pokemon-discounted-price"></span></div>
                <div><span id="quantite"></span></div>
                <button type="button" class="button-ajouter">Ajouter au Panier</button>
            </div>
        </div>
    </div>
</div>

<!-- Script pour la gestion des quantités -->

<!-- Script pour rendre les Pokémon cliquables et gérer l'ajout au panier -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.card');
    const popup = document.getElementById('pokemonPopup');
    const popupName = document.getElementById('pokemonName');
    const popupImage = document.getElementById('pokemonImage');
    const popupDescription = document.getElementById('pokemonDescription');
    const quantiteElement = document.getElementById('quantite');
    const closePopup = document.querySelector('.popup .close');
    const popupId = document.getElementById('pokemonID');
    const addToCartButton = document.querySelector('.button-ajouter');
    let quantitesDisponibles = {};

    // Initialiser les quantités disponibles pour chaque Pokémon
cards.forEach(card => {
    const id = card.getAttribute('data-id');
    const quantiteDisponible = parseInt(card.getAttribute('data-quantite'));
    quantitesDisponibles[id] = quantiteDisponible;
});

    // Fonction pour ouvrir la popup (rendre cliquable)
    function openPopup(id, name, image, description, quantite, price, discountedPrice) {
        popupId.textContent = id;
        popupName.textContent = name;
        popupImage.src = image;
        popupDescription.textContent = description;

        const quantiteDisponible = quantitesDisponibles[id];
        if (quantiteDisponible <= 0) {
            quantiteElement.innerHTML = "<span style='color: red; font-size: 1.5em;'>Victime de son succès</span>";
            addToCartButton.style.display = 'none';  // Désactiver l'ajout au panier uniquement
        } else {
            quantiteElement.innerHTML = `<span style="font-size: 1.5em;">Quantité disponible : <span style="color: green;">${quantiteDisponible}</span></span>`;
            addToCartButton.style.display = 'block';  // Afficher le bouton si le stock est disponible
        }

        document.getElementById('initialPrice').textContent = price;
        document.getElementById('discountedPrice').textContent = discountedPrice;
        popup.style.display = 'block';  // Toujours afficher la popup
    }

    // Rendre les cartes cliquables pour tous les utilisateurs (connectés ou non)
    cards.forEach(card => {
        card.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const image = this.getAttribute('data-image');
            const description = this.getAttribute('data-description');
            const quantite = this.getAttribute('data-quantite');
            const priceElement = this.querySelector('.price') || this.querySelector('.original-price');
            const discountedPriceElement = this.querySelector('.discounted-price');

            const price = priceElement ? priceElement.textContent : 'N/A';
            const discountedPrice = discountedPriceElement ? discountedPriceElement.textContent : priceElement.textContent;

            openPopup(id, name, image, description, quantite, price, discountedPrice);
        });
    });


    // Gérer l'ajout au panier
    addToCartButton.addEventListener('click', function() {
            // Vérifier si l'utilisateur est connecté
        if (!<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>){
            // Si l'utilisateur n'est pas connecté, afficher une popup d'erreur
            alert("Erreur : Vous devez être connecté pour ajouter un Pokémon au panier.");
            return;
        }

        const id = popupId.textContent;
        const quantiteRestante = quantitesDisponibles[id];
        if (quantiteRestante <= 0) {
            alert('Stock épuisé pour ce Pokémon.');
            return;
        }

        // Mise à jour du stock local sans affecter l'API
        quantitesDisponibles[id] -= 1;
        quantiteElement.innerHTML = `<span style="font-size: 1.5em;">Quantité disponible : <span style="color: green;">${quantitesDisponibles[id]}</span></span>`;

        alert("Votre Pokémon a été ajouté au panier");
    });

    // Fermer la popup
    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.card');
    const popup = document.getElementById('pokemonPopup');
    const popupName = document.getElementById('pokemonName');
    const popupImage = document.getElementById('pokemonImage');
    const popupDescription = document.getElementById('pokemonDescription');
    const quantiteElement = document.getElementById('quantite');
    const closePopup = document.querySelector('.popup .close');
    const popupId = document.getElementById('pokemonID');
    const addToCartButton = document.querySelector('.button-ajouter');

    // Stockage local de la quantité de chaque Pokémon
    let quantitesDisponibles = {};

// Initialiser les quantités disponibles pour chaque Pokémon
cards.forEach(card => {
    const id = card.getAttribute('data-id');
    const quantiteDisponible = parseInt(card.getAttribute('data-quantite'));
    quantitesDisponibles[id] = quantiteDisponible;
});

function openPopup(id, name, image, description, quantite, price, discountedPrice) {
    popupId.textContent = id;
    popupName.textContent = name;
    popupImage.src = image;
    popupDescription.textContent = description;

    const quantiteDisponible = quantitesDisponibles[id];

    // Toujours afficher la popup, même si le stock est épuisé
    if (quantiteDisponible <= 0) {
        quantiteElement.innerHTML = "<span style='color: red; font-size: 1.5em;'>Victime de son succès</span>";
        addToCartButton.style.display = 'none';  // Désactiver l'ajout au panier uniquement
    } else {
        quantiteElement.innerHTML = `<span style="font-size: 1.5em;">Quantité disponible : <span style="color: green;">${quantiteDisponible}</span></span>`;
        addToCartButton.style.display = 'block';  // Afficher le bouton si le stock est disponible
    }

    document.getElementById('initialPrice').textContent = price;
    document.getElementById('discountedPrice').textContent = discountedPrice;
    popup.style.display = 'block';  // Toujours afficher la popup
}

// Associer l'événement click aux cartes pour ouvrir la popup (fonctionne pour tous les utilisateurs)
cards.forEach(card => {
    card.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const image = this.getAttribute('data-image');
        const description = this.getAttribute('data-description');
        const quantite = this.getAttribute('data-quantite');
        const priceElement = this.querySelector('.price') || this.querySelector('.original-price');
        const discountedPriceElement = this.querySelector('.discounted-price');

        const price = priceElement ? priceElement.textContent : 'N/A';
        const discountedPrice = (parseFloat(priceElement.textContent) * 0.8).toFixed(2) + '€';

        

        // Ouvrir la popup même si l'utilisateur n'est pas connecté
        openPopup(id, name, image, description, quantite, price, discountedPrice);
    });
});

// Fermer la popup
closePopup.addEventListener('click', function() {
    popup.style.display = 'none';
});

// Ajouter au panier (vérification si l'utilisateur est connecté, sinon désactiver l'ajout)
addToCartButton.addEventListener('click', function() {
    const id = popupId.textContent;
    const quantiteRestante = quantitesDisponibles[id];
    if (quantiteRestante <= 0) {
        alert('Stock épuisé pour ce Pokémon.');
        return;
    }

    // Mise à jour du stock local sans affecter l'API
    quantitesDisponibles[id] -= 1;
    quantiteElement.innerHTML = `<span style="font-size: 1.5em;">Quantité disponible : <span style="color: green;">${quantitesDisponibles[id]}</span></span>`;

});

// Gestion des éléments de la popup des avis
const avisPopup = document.getElementById('avisPopup');
const closeAvisPopup = document.querySelector('.close-avis');
const avisContainer = document.getElementById('avisContainer');
const formAddReview = document.getElementById('formAddReview');
const addReviewForm = document.getElementById('addReviewForm');  // Formulaire pour ajouter un avis
const viewReviewsButton = document.createElement('button');  // Ajouter le bouton "Voir les Avis"

// Ajout dynamique du bouton "Voir les Avis"
viewReviewsButton.textContent = "Voir les avis";
viewReviewsButton.classList.add('btn', 'btn-info'); // Ajout de style
document.querySelector('.popup-text-content').appendChild(viewReviewsButton);

function afficherAvis(avis) {
    avisContainer.innerHTML = ''; // Vider les avis précédents
    if (avis.length === 0) {
        avisContainer.innerHTML = '<p>Aucun avis n\'a été déposé sur ce produit.</p>';
    } else {
        avis.forEach(avis => {
            const avisDiv = document.createElement('div');
            avisDiv.classList.add('avis');
            avisDiv.innerHTML = `
                <strong>${avis.utilisateur}</strong> - Note : ${avis.note}/5<br>
                <p>${avis.commentaire}</p>
                <small>${new Date(avis.date_creation).toLocaleString()}</small>
            `;

            // Si l'utilisateur est admin, ajouter un bouton pour supprimer l'avis
            <?php if (isset($_SESSION['user_statut']) && $_SESSION['user_statut'] === 'admin'): ?>
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Supprimer';
                deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // Style bouton
                deleteButton.addEventListener('click', function() {
                    const token = localStorage.getItem('access_token'); // Récupérer le token JWT

                    // Vérifier si le token est présent
                    if (!token) {
                        alert('Vous devez être authentifié pour supprimer cet avis.');
                        return;
                    }

                    // Appel API pour supprimer l'avis
                    fetch(`http://127.0.0.1:8000/api/avis/${avis.id}/supprimer-avis/`, {
                        method: 'DELETE',
                        headers: {
                            'Authorization': `Bearer ${token}`, // Ajouter le token JWT dans les headers
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Avis supprimé');
                            avisDiv.remove();
                        } else {
                            response.json().then(data => {
                                alert('Erreur lors de la suppression de l\'avis : ' + data.error);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la suppression de l\'avis :', error);
                        alert('Une erreur est survenue lors de la suppression.');
                    });
                });
                avisDiv.appendChild(deleteButton);
            <?php endif; ?>

            avisContainer.appendChild(avisDiv);
        });
    }
}

// Ouverture de la popup des avis pour tous les utilisateurs (connectés ou non)
viewReviewsButton.addEventListener('click', function() {
    const pokemonId = popupId.textContent;

    // Appeler l'API pour récupérer les avis du produit
    fetch(`http://127.0.0.1:8000/api/produits/${pokemonId}/avis/`)
        .then(response => response.json())
        .then(avis => {
            afficherAvis(avis);  // Afficher les avis
            avisPopup.style.display = 'block';  // Afficher la popup des avis
        })
        .catch(error => console.error('Erreur lors de la récupération des avis :', error));
});

// Fermer la popup des avis
closeAvisPopup.addEventListener('click', function() {
    avisPopup.style.display = 'none';
});


// Vérification de l'achat pour afficher le formulaire d'avis
function verifierAchat(pokemonId) {
    fetch(`verifier_achat.php?produit_id=${pokemonId}`)
        .then(response => response.json())
        .then(data => {
            if (data.achat || <?php echo ($_SESSION['user_statut'] === 'admin') ? 'true' : 'false'; ?>) {
                addReviewForm.style.display = 'block';  // Afficher le formulaire pour ajouter un avis
            } else {
                addReviewForm.style.display = 'none';  // Masquer le formulaire si l'utilisateur ne peut pas ajouter d'avis
            }
        })
        .catch(error => console.error('Erreur lors de la vérification de l\'achat :', error));
}

// Ouverture de la popup des avis
function openAvisPopup(pokemonId) {
    // Appeler l'API pour récupérer les avis du produit
    fetch(`http://127.0.0.1:8000/api/produits/${pokemonId}/avis/`)
        .then(response => response.json())
        .then(avis => {
            afficherAvis(avis);  // Afficher les avis
            verifierAchat(pokemonId);  // Vérifier si l'utilisateur peut ajouter un avis
            avisPopup.style.display = 'block';  // Afficher la popup des avis
        })
        .catch(error => console.error('Erreur lors de la récupération des avis :', error));
}

// Gestion de l'ouverture de la popup des avis via le bouton "Voir les avis"
viewReviewsButton.addEventListener('click', function() {
    const pokemonId = popupId.textContent;
    openAvisPopup(pokemonId);  // Appeler la fonction pour afficher les avis
});

// Soumission du formulaire d'ajout d'avis
formAddReview.addEventListener('submit', function(event) {
    event.preventDefault();
    const pokemonId = popupId.textContent;
    const note = document.getElementById('note').value;
    const commentaire = document.getElementById('commentaire').value;

    // Récupérer le token JWT depuis la session ou un cookie
    const token = localStorage.getItem('access_token');  // Adapte selon la méthode de stockage du token

    // Appel API pour ajouter un avis
    fetch(`http://127.0.0.1:8000/api/produits/${pokemonId}/ajouter-avis/`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`  // Ajouter le token dans les headers
        },
        body: JSON.stringify({note: parseInt(note), commentaire: commentaire})
    })
    .then(response => {
        if (response.ok) {
            alert('Avis ajouté avec succès');
            // Recharger les avis
            viewReviewsButton.click();
        } else {
            alert('Erreur lors de l\'ajout de l\'avis');
        }
    });
});

// Fermeture de la popup des avis
closeAvisPopup.addEventListener('click', function() {
    avisPopup.style.display = 'none';
});



});
</script>


<!-- Script pour le filtrage par type -->
<script>
// Script pour le filtrage par type et légendaire
document.addEventListener("DOMContentLoaded", function() {
    const typeFilter = document.getElementById('type-filter');
    const legendaryFilter = document.getElementById('legendary-filter');  // Ajout du filtre légendaire
    const cards = document.querySelectorAll('.card');

    function filterCards() {
        const selectedType = typeFilter.value.toLowerCase();
        const selectedLegendary = legendaryFilter.value.toLowerCase();

        cards.forEach(card => {
            const type1 = card.getAttribute('data-type').toLowerCase();
            const type2 = card.getAttribute('data-type2').toLowerCase();
            const isLegendary = card.getAttribute('data-legendaire').toLowerCase();

            const matchesType = (selectedType === '' || type1 === selectedType || type2 === selectedType);
            const matchesLegendary = (selectedLegendary === '' || isLegendary === selectedLegendary);

            if (matchesType && matchesLegendary) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Ajouter les écouteurs d'événements pour les filtres
    typeFilter.addEventListener('change', filterCards);
    legendaryFilter.addEventListener('change', filterCards);  // Ajout du listener pour le filtre légendaire
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
.popup-content .close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px; /* Taille plus grande */
    cursor: pointer;
    color: #ff0000; /* Couleur rouge pour attirer l'attention */
    font-weight: bold;
}

.popup-content .close:hover {
    color: #cc0000; /* Couleur légèrement plus foncée au survol */
}
.pokemon-type {
  display: block;
}
.button-avis {
    background-color: #28a745; /* Couleur de fond vert */
    color: white; /* Couleur du texte */
    border: none; /* Supprimer les bordures */
    padding: 10px 20px; /* Ajouter un peu de padding */
    font-size: 16px; /* Ajuster la taille du texte */
    border-radius: 5px; /* Ajouter des bordures arrondies */
    cursor: pointer; /* Changer le curseur en pointeur */
    transition: background-color 0.3s ease; /* Ajouter une transition pour le changement de couleur */
    margin-top: 10px; /* Ajouter un peu d'espace au-dessus du bouton */
}

.button-avis:hover {
    background-color: #218838; /* Changer la couleur de fond au survol */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Ajouter un léger effet d'ombre au survol */
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
/* Style de la popup des avis */
.popup-content-avis {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
    max-width: 600px;
    margin: auto;
    position: relative;
}

/* Style pour la croix de fermeture */
.popup-content-avis .close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 25px;
    cursor: pointer;
    color: #333;
    transition: color 0.3s ease;
}

.popup-content-avis .close:hover {
    color: #ff0000;
}

/* Style des avis */
.avis-container {
    margin-top: 20px;
}

.avis {
    border-bottom: 1px solid #ddd;
    padding: 15px 0;
}

.avis:last-child {
    border-bottom: none;
}

.avis strong {
    font-size: 1.1em;
    margin-bottom: 5px;
}

.avis p {
    margin: 10px 0;
    color: #555;
}

.avis .note {
    font-weight: bold;
    color: #f39c12;
}

/* Style de la date */
.avis-date {
    font-size: 0.9em;
    color: #999;
    margin-top: 10px;
}

/* Style pour le bouton "Écrire un avis" */
.button-ecrire-avis {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.button-ecrire-avis:hover {
    background-color: #0056b3;
}

/* Style pour la section "Aucun avis" */
.no-avis {
    font-size: 1.2em;
    color: #555;
    text-align: center;
    padding: 20px 0;
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
<!-- Popup pour les avis -->
<div id="avisPopup" class="popup" style="display: none;">
    <div class="popup-content">
        <span class="close-avis">&times;</span>
        <div id="avisContainer">
            <!-- Les avis seront chargés ici dynamiquement -->
        </div>
        <!-- Formulaire pour ajouter un avis (sera affiché si l'utilisateur peut ajouter un avis) -->
        <div id="addReviewForm" style="display: none;">
            <h3>Ajouter un avis</h3>
            <form id="formAddReview">
                <label for="note">Note :</label>
                <select id="note" name="note" required>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Très bon</option>
                    <option value="3">3 - Moyen</option>
                    <option value="2">2 - Médiocre</option>
                    <option value="1">1 - Mauvais</option>
                </select>
                <br>
                <label for="commentaire">Commentaire :</label>
                <textarea id="commentaire" name="commentaire" required></textarea>
                <br>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
