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

    <nav class="jumbo-nav">
        <div class="container">
            <div class="row" id="recommendations-container">
                <!-- Les recommandations de Pokémon seront injectées ici via JS -->
            </div>
        </div>
    </nav>

    <script>
        $(document).ready(function () {
            let apiUrl;

            // Vérifier si l'utilisateur est connecté en utilisant la session
            <?php if (isset($_SESSION['user_id'])) { ?>
                const userId = "<?php echo $_SESSION['user_id']; ?>";
                apiUrl = `http://127.0.0.1:8000/api/utilisateurs/${userId}/recommandations/`;
            <?php } else { ?>
                apiUrl = "http://127.0.0.1:8000/api/recommandations/";
            <?php } ?>

            // Faire la requête à l'API
            $.ajax({
                type: "GET",
                url: apiUrl,
                success: function (response) {
                    const recommendations = response.recommendations;

                    recommendations.forEach(pokemon => {
                        const pokemonHtml = `
                            <div class="col-md-4">
                                <div class="pokeball-wrapper">
                                    <img src="img/pokeball.png" />
                                </div>
                                <div class="enhanced">
                                    <h2>${pokemon.nom}</h2>
                                    <img class="pokemon small" src="${pokemon.image.replace('../', '')}" alt="${pokemon.nom}" />
                                    <p>Description : ${pokemon.description}</p>
                                    <p>Type principal : ${pokemon.type_1}</p>
                                    <p>Remise de : <span style="color: red; font-size: 1.5em;">${pokemon.discount}%</span></p>
                                    <p><a class="btn btn-default" href="php/catalogue.php" role="button">View details &raquo;</a></p>
                                </div>
                            </div>
                        `;

                        $('#recommendations-container').append(pokemonHtml);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Erreur lors de la récupération des recommandations : ", error);
                }
            });
        });
    </script>
</body>

<?php include_once('include/footer.php'); ?>
</html>
