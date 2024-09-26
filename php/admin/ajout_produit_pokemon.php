<?php 
    session_start();
    require  '../../include/databaseconnect.php';
    if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
        header('Location: ../../index.php');
        exit;
    }
    
?>
<script>
    $("#ajtPokemon").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter un produit</title>
        <script src="../../js/pokemon.js" defer></script>
        <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="../../css/pokedex.css">
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="icon" type="image/png" href="../../img/icon.png"/>
    </head>

    <?php include_once('../../include/header.php'); ?>
    <script>
        $("#ajtPokemon").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
    </script>

    <main class="col overflow-auto h-100 w-100">
                <a class="btn btn-dark btn-sm" href="ajout_pok.php">← Retour</a><br><br>

                <?php
              // Vérification si le formulaire a été soumis
if (isset($_POST['ajouter'])) {
    // Récupération des valeurs du formulaire
    $nom = htmlentities($_POST['nom'], ENT_QUOTES, 'UTF-8');
    $type_1 = htmlentities($_POST['type_1'], ENT_QUOTES, 'UTF-8');
    $type_2 = htmlentities($_POST['type_2'], ENT_QUOTES, 'UTF-8');
    $generation = $_POST['generation'];
    $légendaire = isset($_POST['légendaire']) ? 1 : 0; // Convertit en 1 si coché, 0 sinon
    $prix = $_POST['prix'];
    $discount = $_POST['discount'];
    $description = htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8');
    $quantite = $_POST['quantite'];
    // Assignation d'une image par défaut pour le produit
    $filename = 'pokeball.png';

    // Vérification si une image a été téléchargée
    if (!empty($_FILES['image']['name'])) {
        // Génération d'un nom unique pour l'image et ajout de l'extension de l'image
        $image = $_FILES['image']['name'];
        $filename = '../../img/'.uniqid() . $image;
    }

                    // Vérification si les champs obligatoires ont été remplis
                    if (!empty($nom) && !empty($type_1)  && !empty($prix) && !empty($description)) {
                        $sqlState = $bdd->prepare('INSERT INTO Pokedex VALUES (null,?,?,?,?,?,?,?,?,?,?)');
                        $inserted = $sqlState->execute([$nom, $type_1, $type_2, $generation, $légendaire, $prix, $discount, $filename, $quantite, $description]);
                        
                        // Vérification si l'insertion a été réussie
                        if ($inserted) {
                            // Déplacement de l'image téléchargée dans le dossier de destination
                            move_uploaded_file($_FILES['image']['tmp_name'], '../../img/' . $filename);

                            // Redirection vers la page des produits
                            header('location: ajout_pok.php');
                        } else {
                            // Affichage d'un message d'erreur si l'insertion a échoué
                            echo '<div class="alert alert-danger" role="alert">Erreur lors de l\'insertion dans la base de donnée. Vérifiez que vous avez bien respecté les contraintes sur le format des informations.</div>';
                        }
                    } else {
                        // Affichage d'un message d'erreur si les champs obligatoires ne sont pas remplis
                        echo '<div class="alert alert-danger" role="alert">Des libellé sont obligatoire sont obligatoires.</div>';
                    }
                }
            ?>

<!--Début du formulaire pour ajouter un produit-->
            <form method="post" enctype="multipart/form-data">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" name="nom">

                <label class="form-label">Type 1 </label>
                <input type="text" class="form-control" name="type_1">

                <label class="form-label">Type 2</label>
                <input type="text" class="form-control" name="type_2">

                <label class="form-label">Generation</label>
                <input type="number" class="form-control" step="1" name="generation" min="0">

                <label class="form-label">Légendaire</label>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="légendaire" value="oui">
                    <label class="form-check-label" for="légendaire">
                        Oui
                    </label>
                </div>
                <label class="form-label">Prix</label>
                <input type="number" class="form-control" step="0.01" name="prix" min="0">

                <label class="form-label">Discount&nbsp&nbsp</label><output name="discountOutput" for="discount">0</output>%
                <input type="range" value="0" class="form-control" name="discount" min="0" max="90" oninput="discountOutput.value = discount.value">

                <label class="form-label">Description (255 caractères maximum)</label>
                <textarea class="form-control" name="description"></textarea>

                <label class="form-label">Quantité</label>
                <input type="number" class="form-control" name="quantite" min="0" required="required"></input>

                <label class="form-label">Image</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" class="form-control" name="image">

                <input type="submit" value="Ajouter produit" class="btn btn-primary my-2" name="ajouter">
                </form>

                