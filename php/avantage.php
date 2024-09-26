<?php 
    session_start();
    require  '../include/databaseconnect.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avantages | Pokeshop</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style-avantage.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
</head>
<body>

<?php include_once('../include/header.php'); ?>
<script>
    $("#avantage").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>

<style>
  
  body {
  background-color: #f4f4f4; /* Couleur de fond grise */
  font-family: 'Arial', sans-serif; /* Police d'écriture */
}

/* Style pour le titre "Le programme de fidélité" */
.program-title {
  color: #000; /* Couleur de texte noire */
  font-size: 30px; /* Taille de la police */
  font-weight: bold; /* Police en gras */
  text-align: center; /* Alignement du texte au centre */
  margin-bottom: 10px; /* Espacement en bas du titre */
}

/* Style pour la description du programme */
.program-description {
    padding: 20px;
    background-color: #fff;
    margin: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

  
  button {
    background-color: #FFA07A; /* Couleur orange pastel */
    color: black;
    padding: 15px 30px;
    font-size: 18px;
    border: none;
    border-radius: 5px; /* Bordures arrondies pour le bouton */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Ombre douce pour le bouton */
    cursor: pointer;
    margin-top: 20px;
    transition: background-color 0.3s ease; /* Animation douce pour le survol */
  }
  button:hover {
    background-color: #FF7F50; /* Couleur plus foncée au survol */
  }
  .button-container {
  text-align: center;
}


  p {
    padding: 0 20px;
    text-align: justify;
}



/* Media query pour ajuster la taille sur les petits écrans */
@media (max-width: 768px) {
  .program-title {
    font-size: 20px; /* Taille de la police plus petite */
  }
  .program-description {
    font-size: 16px; /* Taille de la police plus petite */
  }
  .join-button {
    padding: 10px 20px; /* Padding intérieur réduit */
  }
}

</style>
<body><br><br><br>
<body>

<div class="program-title">Le programme de fidélité Pokeshop à seulement 9.99 €/an</div>
<div class="program-description">
    <p>Rejoignez dès maintenant le programme de fidélité Pokeshop et commencez à cumuler des points à chaque commande pour bénéficier d'avantages exclusifs.</p>
    <p>En devenant membre de notre programme de fidélité, vous accédez à une multitude d'avantages. Vous profiterez de réductions attractives, d'offres spéciales, mais aussi d'invitations à des événements exclusifs et à des avant-premières de nouvelles sorties. </p>
    <br><p><em>Que votre quête soit de trouver le Pokémon légendaire de vos rêves ou de compléter votre collection par génération, notre vaste sélection est là pour satisfaire chaque besoin.</em></p>


</div>


<br><br>
<div class="container">
  <div class="text-with-image">
    <div class="text">
      <h1>Dresseur débutant</h1>
      <em>Entre 0 et 150 €</em>
      <p>En tant que débutant, vous recevrez <strong>un cadeau de bienvenue</strong> spécial pour marquer le début de votre aventure. De plus, vous aurez un accès exclusif aux ventes privées de Pokémon, où vous pourrez trouver des Pokémon rares et des articles de collection. Profitez de ces avantages pour commencer votre voyage avec un coup de pouce!</p>
    </div>
    <div class="image-right">
      <img src="../img/image1.png" alt="Dresseur débutant">
    </div>
  </div>
  
  <div class="image-with-text">
    <div class="text2">
      <h1>Dresseur intermédiaire</h1>
      <em>Entre 150 et 550 €</em>
      <p> À ce stade, vous êtes récompensé pour vos efforts avec la possibilité de recevoir <strong> des cadeaux spéciaux </strong>. Ces cadeaux peuvent inclure des objets utiles pour vos Pokémon, des bonus de points ou même des invitations à des événements exclusifs réservés aux dresseurs intermédiaires. Continuez à explorer le monde Pokémon et à entraîner vos Pokémon pour atteindre ce niveau et obtenir des récompenses encore plus grandes!</p>
    </div>
    <div class="image2">
      <img src="../img/image2.png" alt="Dresseur intermédiaire">
    </div>
  </div>
</div>

<div class="container">
  <div class="text-with-image">
    <div class="text">
      <h1>Dresseur d'élite</h1>
      <em>Entre 550 et 1000 €</em>
      <p>Le statut de dresseur d'élite est réservé à ceux qui ont atteint un niveau exceptionnel de compétence et de dévouement. Vous rejoignez les rangs des dresseurs les plus prestigieux et les plus respectés.  En tant que dresseur d'élite, vous bénéficiez de <strong>privilèges exclusifs </strong>, tels que l'accès à des Pokémon légendaires, des défis spéciaux réservés aux meilleurs dresseurs et même la possibilité de participer à des tournois d'élite pour des récompenses fabuleuses !</p>
    </div>
    <div class="image-right">
      <img src="../img/image3.png" alt="Dresseur d'élite">
    </div>
  </div>
</div>

<div class="button-container">
  <button class="button" >J'adhère au programme</button>
</div>

<br><br><br>
  <?php include_once('../include/footer.php'); ?>
</html>