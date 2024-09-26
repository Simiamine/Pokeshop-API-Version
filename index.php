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
    <link rel="stylesheet" href="css/style.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jumbotron.css" rel="stylesheet">
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

      </div>
    </nav><br><br><br>
    <?php
    require  'include/databaseconnect.php';

    $requete = $bdd->query("SELECT * FROM Pokedex ORDER BY RAND() LIMIT 3");
    ?>

<nav class="jumbo-nav">
  <div class="container">
    <div class="row">
      <?php
        while ($row = $requete->fetch()) {
          $imgPath = "./img/" . $row['image']; 
          echo '<div class="col-md-4">';
          echo '  <div class="pokeball-wrapper">';
          echo '    <img src="./img/pokeball.png" />'; 
          echo '  </div>';
          echo '  <div class="enhanced">';
          echo '    <h2>' . htmlspecialchars($row['nom']) . '</h2>'; 
          echo '    <img class="pokemon small" src="' . htmlspecialchars($imgPath) . '" />'; 
          echo '    Description : ' . html_entity_decode($row['description']) . '</p>'; 
          echo '    Type principal : ' . htmlspecialchars($row['type_1']) . '</p>'; 
          echo '     Remise de : <a style="color: red; font-size: 1.5em;">' . htmlspecialchars($row['discount']) . '%</p>'; 
          echo '    <p><a class="btn btn-default" href="php/catalogue.php" role="button">View details &raquo;</a></p>';
          echo '  </div>';
          echo '</div>';
        }
      ?>
    </div>
  </div>
</nav>

    

</body>
<?php include_once('include/footer.php'); ?>
</html>
