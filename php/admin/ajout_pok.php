<?php 
    session_start();
    require  '../../include/databaseconnect.php';
    if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
        header('Location: ../../index.php');
        exit;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <script src="../js/pokemon.js" defer></script>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="icon" type="image/png" href="../../img/icon.png"/>

    </head>

    <?php include_once('../../include/header.php'); ?>
    <script>
        $("#pokemon").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
    </script>

<div class="mt-3 container-fluid pb-3 flex-grow-1 d-flex flex-column flex-sm-row overflow-auto">
        <div class="row flex-grow-sm-1 flex-grow-0 container-fluid">
            <main class="col overflow-auto h-100 w-100">
                <div class="container py-2">
                    <h2>Liste des pokemons</h2>
                    <a href="ajout_produit_pokemon.php" class="btn btn-primary">Ajouter produit</a>
                    <table class="table table-striped table-hover">
                        <!-- Début de l'en-tête du tableau -->
                        <thead>
                            <tr>
                                <!-- Définition des colonnes du tableau -->
                        
                                <th>Nom</th>
                                <th>1er type</th>
                                <th>2eme type</th>
                                <th>Legendaire</th>
                                <th>Prix</th>
                                <th>Discount</th>
                                <th> Description</th>
                                <th>Quantité</th>
                                <th>Image</th>
                    
                                <th>Opérations</th>
                            </tr>
                        </thead>
  <!-- Début de la ligne du tableau pour le produit -->
  <?php
// Récupération des données depuis la base de données
$requete = $bdd->query("SELECT * FROM Pokedex");
while ($pokemon = $requete->fetch()) {
    echo "<tr>";
    echo "<td>" . $pokemon['nom'] . "</td>";
    echo "<td>" . $pokemon['type_1'] . "</td>";
    echo "<td>" . $pokemon['type_2'] . "</td>";
    echo "<td>" . $pokemon['légendaire'] . "</td>";
    echo "<td>" . $pokemon['prix'] . "</td>";
    echo "<td>" . $pokemon['discount'] . "</td>";
    echo "<td>" . $pokemon['description'] . "</td>";
    echo "<td>" . $pokemon['quantité'] . "</td>";
    echo "<td><img src='../../img/" . $pokemon['image'] . "' alt='Image du pokemon' width='90'></td>";
    
    echo "<td>
    <a class='btn btn-primary' 
        href='modification_pok.php?id=" . $pokemon['id'] . "'>Modifier </a>";
    echo " <td><a class='btn btn-danger' 
        href='supp_produit.php?id=" . $pokemon['id'] . "' onclick=\"return confirm('Voulez-vous vraiment supprimer le produit " . addslashes($pokemon['nom']) . " ?')\">Supprimer</a>";
    echo "</tr>";

}

?>
                    </table>

