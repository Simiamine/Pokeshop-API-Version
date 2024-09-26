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
    <title>Modifier un produit</title>
    <script src="../js/pokemon.js" defer></script>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/pokedex.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    </head>

    <section id="header">
        <div class="logo">
            <a href="../index.php"><img src="../../img/icon.png" alt="pokeball" class = "logo" width="50"></a>
        </div>
        <ul id="navbar">
          <li>Compte_Admin </li>
            <li><a href="../../index.php" id="menu">Menu</a></li>
            <li><a href="#" id="type">Analyse</a></li>
            <li><a class="active" href="ajout_pok.php" id="abonnement"> Pokemons</a></li>
            <li><a href="#" id="contact">Commandes</a></li>
            <li><a href="../deconnexion.php" id="deconnexion">Déconnexion</a></li>
        </ul>
    </section>
    <main class="col overflow-auto h-100 w-100">
                <a class="btn btn-dark btn-sm" href="ajout_pok.php">← Retour</a><br><br>

                 <!-- Affichage d'un titre de niveau 4 -->
                 <h4>Modifier Pokemon</h4>

                 <?php
                    // Récupération de l'identifiant du produit à modifier depuis l'URL
                    $id = $_GET['id'];

                    // Préparation d'une requête SQL pour obtenir les détails du produit à modifier
                    $sqlState = $bdd->prepare('SELECT * from Pokedex WHERE id=?');
                    $sqlState->execute([$id]);

                    // Récupération des détails du produit
                    $pokedex = $sqlState->fetch(PDO::FETCH_OBJ);

                    // Vérification si le formulaire de modification a été soumis
                    if (isset($_POST['modifier'])) {
                        // Récupération des nouvelles valeurs des champs du formulaire
                        $nom = htmlentities($_POST['nom'], ENT_QUOTES, 'UTF-8');
                        $type_1 = htmlentities($_POST['type_1'], ENT_QUOTES, 'UTF-8');
                        $type_2 = htmlentities($_POST['type_2'], ENT_QUOTES, 'UTF-8');
                        $generation = $_POST['generation'];

                        $prix = $_POST['prix'];
                        $discount = $_POST['discount'];
                        $quantité = $_POST['quantité'];

                        $description = htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8');
                        $filename = '';
                        // Vérification si une nouvelle image a été téléchargée
                        if (!empty($_FILES['image']['name'])) {
                            $image = $_FILES['image']['name'];
                            $filename = uniqid() . $image;
                            // Déplacement de l'image téléchargée vers le dossier 'img'
                            move_uploaded_file($_FILES['image']['tmp_name'], '../../img' . $filename);
                        }

                        // Vérification si tous les champs obligatoires sont remplis
                        if (!empty($nom) && !empty($prix) && !empty($type_1) && !(empty($generation)) && !(empty($quantité)) && !(empty($description))) {
                            // Préparation de la requête SQL pour mettre à jour les détails du produit
                            if (!empty($filename)) {
                                $query = "UPDATE Pokedex SET nom=? ,type_1=?, type_2=?, generation=?, prix=?, discount=?, description=?, image=?, quantité=? WHERE id = ? ";
                                $sqlState = $bdd->prepare($query);
                                $updated = $sqlState->execute([$nom, $type_1, $type_2, $generation, $prix, $discount, $description, $filename, $quantité, $id]);
                            } else {
                                $query = "UPDATE Pokedex SET nom=? ,type_1=?, type_2=?, generation=?, prix=?, discount=?, description=?, quantité=? WHERE id = ? ";
                                $sqlState = $bdd->prepare($query);
                                $updated = $sqlState->execute([$nom, $type_1, $type_2, $generation, $prix, $discount, $description, $quantité, $id]);
                            }

                            if ($updated) {
                                header('location: ajout_pok.php');
                            } else {
                                ?>
                                    <div class="alert alert-danger" role="alert">
                                        Erreur lors de l'insertion dans la base de donnée. Vérifiez que vous avez bien respecté les contraintes sur le format des informations.
                                    </div>
                                    <?php
                                }
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                erreur 
                            </div>
                            <?php
                        }

                    }?>

                
<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?=$pokedex->id ?>">

    <label class="form-label">Nom :</label>
    <input type="text" class="form-control" name="nom" value="<?= $pokedex->nom ?>">

    <label class="form-label">Type 1 :</label>
    <input type="text" class="form-control" name="type_1" value="<?= $pokedex->type_1 ?>">

    <label class="form-label">Type 2:</label>
    <input type="text" class="form-control" name="type_2" value="<?= $pokedex->type_2 ?>">

    <label class="form-label">Génération</label>
    <input type="number" class="form-control" step="1" name="generation" min="1" value="<?= $pokedex->generation ?>">
    
    <label class="form-label">Prix</label>
    <input type="number" class="form-control" step="0.1" name="prix" min="0" value="<?= $pokedex->prix ?>">

    <label class="form-label">Discount</label>
    <input type="range" value="0" class="form-control" name="discount" min="0" max="90" value="<?= $pokedex->discount ?>">

    <label class="form-label">Description (maximum 255 caractères)</label>
    <textarea class="form-control" name="description"><?= $pokedex->description ?></textarea>

    <label class="form-label">Quantité</label>
    <input type="number" class="form-control" name="quantité" min="0" value="<?php echo $pokedex->quantité?>">
  
     <!-- Champ pour télécharger l'image du produit -->
     <label class="form-label">Image</label>
    <input type="file" accept="image/png, image/jpeg, image/jpg" class="form-control" name="image">

    <!-- Affichage de l'image actuelle du produit -->
    <img width="250" class="img img-fluid" src="../../img/<?= $pokedex->image ?>"><br>

    <!-- Bouton pour soumettre le formulaire -->
    <input type="submit" value="Modifier produit" class="btn btn-primary my-2" name="modifier">
</form>
