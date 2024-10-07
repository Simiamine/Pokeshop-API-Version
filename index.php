<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokeshop</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jumbotron.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style2.css">
    <link rel="icon" type="image/png" href="img/icon.png"/>
</head>

<?php include_once('include/header.php'); ?>
<script>
    $("#menu").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>

<body>
    <div id="offreTemp">
      !&nbsp!&nbsp! &nbsp&nbsp EN CE MOMENT -20% SUR TOUTE LA BOUTIQUE AVEC LE CODE : <u><span id="code">MemePasUnPeu?</span></u> &nbsp&nbsp !&nbsp!&nbsp!
    </div>

    <section id="hero">
        <h2>Achetez votre propre</h2>
        <h1>Pokémon !</h1>
        <button id="boutonAchete" onclick="location.href='php/catalogue.php';">Achetez dès maintenant !</button>
    </section>

    <br><br><br>

    <script>
    $(document).ready(function() {
        // Vérifier si l'utilisateur est connecté en vérifiant la session
        var accessToken = '<?php echo isset($_SESSION['access_token']) ? $_SESSION['access_token'] : ''; ?>';
        var url = 'http://127.0.0.1:8000/api/recommandations/';
        var headers = {};

        // Si l'utilisateur est connecté, ajouter le token dans le header
        if (accessToken) {
            headers['Authorization'] = 'Bearer ' + accessToken;
        }

        // Appel à l'API pour récupérer les recommandations
        $.ajax({
    type: "GET",
    url: "http://127.0.0.1:8000/api/recommandations/",
    success: function(response) {
        var recommendations = response.recommendations;
        var content = '';

        // Boucle à travers les recommandations pour afficher chaque Pokémon
        recommendations.forEach(function(pokemon) {
            var imgPath = pokemon.image.replace("../img", "./img");  // Correction du chemin de l'image
            content += '<div class="col-md-4">';
            content += '  <div class="pokeball-wrapper">';
            content += '    <img src="./img/pokeball.png" />';
            content += '  </div>';
            content += '  <div class="enhanced">';
            content += '    <h2>' + pokemon.nom + '</h2>';
            content += '    <img class="pokemon small" src="' + imgPath + '" />';  // Utilisation de l'image avec le chemin corrigé
            content += '    <p>Description : ' + pokemon.description + '</p>';
            content += '    <p>Type principal : ' + pokemon.type_1 + '</p>';
            content += '    <p style="color: red; font-size: 1.5em;">Remise de : ' + pokemon.discount + '%</p>';
            content += '    <p><a class="btn btn-default" href="php/catalogue.php" role="button">View details &raquo;</a></p>';
            content += '  </div>';
            content += '</div>';
        });

        // Insère le contenu dans la section appropriée de la page
        $('.jumbo-nav .container .row').html(content);
    },
    error: function(xhr, status, error) {
        console.error("Erreur lors de la récupération des recommandations : ", error);
    }
});

    });
    </script>

    <nav class="jumbo-nav">
      <div class="container">
        <div class="row">
          <!-- Les Pokémon seront affichés ici -->
        </div>
      </div>
    </nav>

</body>
<?php include_once('include/footer.php'); ?>
</html> 
