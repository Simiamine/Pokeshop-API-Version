<?php 
    session_start();
    require  '../include/databaseconnect.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/catalogue.js"></script>
    <title>Pokedex</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
     <!-- j'ai modifié -->
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

<div class="cards-container">
<?php
$requete = $bdd->query("SELECT * FROM Pokedex");
foreach ($requete as $pokemon) {
    $bg_color = "#929da3";

    switch ($pokemon['type_1']) {
        case 'normal':
            $bg_color = "#929da3";
            break;
        case 'combat':
            $bg_color = "#cf406b";
            break;
        case 'vol':
            $bg_color = "#8fa8df";
            break;
        case 'poison':
            $bg_color = "#ab6ac8";
            break;
        case 'sol':
            $bg_color = "#d97944";
            break;
        case 'roche':
            $bg_color = "#c5b68d";
            break;
        case 'insecte':
            $bg_color = "#91c12f";
            break;
        case 'spectre':
            $bg_color = "#5268ac";
            break;
        case 'acier':
            $bg_color = "#5b8ea3";
            break;
        case 'feu':
            $bg_color = "#fe9d54";
            break;
        case 'eau':
            $bg_color = "#5190d7";
            break;
        case 'plante':
            $bg_color = "#63bc5a";
            break;
        case 'electrique':
            $bg_color = "#f5d33c";
            break;

        default: 
            echo "";
            break;
    }   
    // Utilisez $bg_color comme vous le souhaitez ici

    ?>

   <div class="card" style="width: 18rem; background-color: <?php echo $bg_color; ?>;"
        data-id="<?php echo $pokemon['id']; ?>" 
        data-name="<?php echo $pokemon['nom']; ?>" 
        data-image="../img/<?php echo $pokemon['image']; ?>" 
        data-description="<?php echo $pokemon['description']; ?>"
        data-type="<?php echo $pokemon['type_1']; ?>"
        data-type2="<?php echo $pokemon['type_2']; ?>"
        generation ="<?php echo $pokemon['generation']; ?>"
        legendaire ="<?php echo $pokemon['légendaire']; ?>"
        quantite ="<?php echo $pokemon['quantité']; ?>"
        
        
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
            // Affiche simplement le prix original sans le barrer
        ?>
            <p class="card-text">
                Prix: <span class="price"><?php echo number_format($prixOriginal, 2, '.', ''); ?>€</span>
            </p>
            <?php
    }
?>
<div id="no-results" style="display: none;">
    <p>Désolé, nous n'avons pas trouvé de résultat pour votre recherche. Voici quelques produits qui pourraient vous intéresser :</p>
    <div id="suggested-pokemon"></div>
</div>

    </div>
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
            <div><strong>Legendaire : </strong><span id="legendaire" class="pokemon-legendaire"></span></div>
            <div> <strong>description : </strong><span id="pokemonDescription"></span></div>
            <div><strong>Prix Initial : </strong><span id="initialPrice" class="pokemon-price"></span></div>
            <div><strong>Prix après Remise : </strong><span id="discountedPrice" class="pokemon-discounted-price"></span></div>
            <div><span id="quantite"></span></div>
             <!-- Bouton Ajouter au Panier avec couleur adaptée -->
            <button type="button" class="button-ajouter" style="background-color: <?php echo $bg_color; ?>;">Ajouter au Panier</button>
            </div>
        </div>
    </div>
</div>
<?php
    }
 ?>
<script>

//barre de recherche
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('search-input');
    const cards = document.querySelectorAll('.card');
    const noResultsDiv = document.getElementById('no-results');

    searchInput.addEventListener('input', function() {
        const searchText = this.value.toLowerCase();
        let found = false;

        cards.forEach(card => {
            const name = card.querySelector('.card-title').textContent.toLowerCase();
            const types = card.querySelectorAll('.pokemon-type');
            const type1 = types[0] ? types[0].textContent.toLowerCase() : '';
            const type2 = types[1] ? types[1].textContent.toLowerCase() : '';

            // Affiche la carte si le nom commence par searchText ou si l'un des types correspond à searchText
            if (name.startsWith(searchText) || type1 === searchText || type2 === searchText) {
                card.style.display = '';
                found = true;
            } else {
                card.style.display = 'none';
            }
        });

        // Afficher ou cacher la div "no-results" basé sur si un Pokémon a été trouvé
        noResultsDiv.style.display = found ? 'none' : 'block';
    });
});





document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.card');
    const popup = document.getElementById('pokemonPopup');
    const popupName = document.getElementById('pokemonName');
    const popupImage = document.getElementById('pokemonImage');
    const popupDescription = document.getElementById('pokemonDescription');
    const quantite = document.getElementById('quantite');
    const closePopup = document.querySelector('.popup .close');
    const popupid = document.getElementById('pokemonID')
 // Fonction pour ouvrir la pop-up
 function openPopup(id,name, image, description, generation, legendaire, quantite, price, discountedPrice) {
    popupid.textContent =  id;
    popupName.textContent = name;
    popupImage.src = image;
    popupDescription.textContent = description;
    document.getElementById('generation').textContent = generation;
    document.getElementById('legendaire').textContent = legendaire === '1' ? 'Oui' : 'Non';

    // Vérifie la quantité et ajuste l'affichage avec style
    // Dans la fonction openPopup, ajustez la condition pour vérifier la quantité
if (quantite <= 0) {
    document.getElementById('quantite').innerHTML = "<span style='color: red; font-size: 1.5em;'>Victime de son succès</span>";
    // Cacher le bouton Ajouter au Panier uniquement si le produit est épuisé
    document.querySelector('.button-ajouter').style.display = 'none';
} else {
    // Si le produit n'est pas épuisé, assurez-vous que le bouton est visible
    document.querySelector('.button-ajouter').style.display = 'block'; // Assurez-vous que cette ligne est présente pour réafficher le bouton pour les produits disponibles

    // Vous pouvez aussi ajuster le contenu de 'quantite' pour les produits disponibles si nécessaire
    if (quantite < 5) {
        document.getElementById('quantite').innerHTML = `<span style="font-size: 1.5em;">Attention, il ne reste plus que <span style="color: red;">${quantite}</span> Pokémon !</span>`;
    } else {
        // Pour les produits avec suffisamment de stock, vous pouvez choisir de ne pas afficher de message spécifique
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
        const generation = this.getAttribute('generation');
        const legendaire = this.getAttribute('legendaire');
        const quantite = this.getAttribute('quantite');
        const priceElement = this.querySelector('.price') || this.querySelector('.original-price');
        const discountedPriceElement = this.querySelector('.discounted-price');
    
        const price = priceElement ? priceElement.textContent : 'N/A';
        const discountedPrice = discountedPriceElement ? discountedPriceElement.textContent : priceElement.textContent; // j'ai modifié 

        openPopup(id, name, image, description, generation, legendaire, quantite, price, discountedPrice);
    });
});

    // Gestionnaire de clic pour fermer la pop-up
    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    // j'ai modifié 
    document.querySelector('.button-ajouter').addEventListener('click', function() {
        // Récupérer les données du produit sélectionné
        const name = document.getElementById('pokemonName').textContent;
        //console.log(name);
        const price = document.getElementById('initialPrice').textContent;
        //console.log(price);
        const discountedPrice = document.getElementById('discountedPrice').textContent;
        //console.log(discountedPrice);
        const ID = document.getElementById('pokemonID').textContent;

        // Créer un objet JSON contenant les informations du produit
        const produit = {
            nom: name,
            prix: price,
            prixApresRemise: discountedPrice,
            pokemon_id: ID
        };
        console.log(produit);

        // Envoyer les données du produit à la page ajouter_au_panier.php via une requête fetch
        fetch('ajouter_au_panier.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(produit)
        })
        .then(response => response.text())
        .then(data => {
            // Traiter la réponse de la page ajouter_au_panier.php si nécessaire
            console.log(data);
        })
        .catch(error => {
            console.error('Erreur lors de l\'ajout au panier:', error);
        });
        alert("Votre Pokémon a été ajouté au panier");
        location.reload();
    });
});
// j'ai modifié 
</script>
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

    /* Styles pour la pop-up */
.popup {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: rgba(0,0,0,0.5); /* Fond semi-transparent */
    display: none; 
    justify-content: center; 
    align-items: center; 
    z-index: 1000; /* S'assure que la pop-up soit au-dessus des autres éléments */

}

.popup-content {
    margin: auto;
    background: white;
    width: 70%; 
    padding: 6%; 
    box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* ajoute une ombre pour un effet de profondeur */
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
    align-items: flex-start; /* Alignement au début du conteneur */
    gap: 20px; /* Espace entre l'image et le contenu textuel */
}

.popup-text-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
}

.popup-text-content h3, .popup-text-content div, .button-ajouter {
    margin-bottom: 15px; /* Espace entre les éléments */
}

#pokemonDescription {
    font-size: 16px;
    margin: 10px 0; /* Espacement autour de la description */
    text-align: justify; /* Alignement du texte pour une lecture facile */
    max-width: 100%; /* Assure que le texte ne dépasse pas du conteneur */
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
    background-color: #0056b3; /* Changement de couleur au survol */
}

/* Responsivité */
@media (max-width: 768px) {
    .popup-flex-container {
        flex-direction: column;
        align-items: center;
    }

    .popup-content {
        width: 80%; /* Largeur plus grande pour les petits écrans */
    }
}

    /*style pour le prix */ 
.original-price {
  text-decoration: line-through; /* Barre le prix original */
  color: #9e9e9e; 
}

.discounted-price {
  color: red; /* Met le nouveau prix en rouge */
  font-weight: bold; 
}

     /*style pour la barre de recherche */ 
.search-wrap {
    display: flex;
    margin-top: 2.5%;
    width: 50%;
    padding: 5px;
    background-color: #757575; 
    margin-left: 25%;
}

.search-input {
    flex-grow: 1;
    padding: 8px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}

.search-btn {
    background-color: #333;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px;
    margin-left: 5px;
    cursor: pointer;
}

     /*style pour le contenue du pokemon */ 
.cards-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-evenly; 
  align-items: center; /* Aligner les cartes sur le haut */
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
  max-width: 20%; /* Empêche les cartes de devenir plus grandes que 20% de la largeur du conteneur */
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
    flex-basis: 48%; /* Sur les tablettes, deux cartes par ligne */
    max-width: 48%;
  }
}

@media (max-width: 767px) {
  .card {
    flex-basis: 100%; /* Sur les mobiles, une carte par ligne */
    max-width: 100%;
  }
}
</style>


 
</body>

</html>


