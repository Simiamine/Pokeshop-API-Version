<?php 
    session_start();
    if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
        header('Location: ../../index.php');
        exit;
    }

    // Récupération de l'ID du Pokémon depuis l'URL
    $currentId = $_GET['id'];
    
    // Récupération des informations du Pokémon via l'API
    $url = 'http://127.0.0.1:8000/api/pokedex/' . $currentId . '/';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Décodage de la réponse de l'API
    $pokedex = json_decode($response);

    if ($httpCode !== 200 || !$pokedex) {
        echo "<div class='alert alert-danger'>Erreur lors de la récupération des données du Pokémon via l'API.</div>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un produit</title>
    <script src="../js/pokemon.js" defer></script>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/pokedex.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
</head>

<section id="header">
    <div class="logo">
        <a href="../index.php"><img src="../../img/icon.png" alt="pokeball" class="logo" width="50"></a>
    </div>
    <ul id="navbar">
        <li>Compte_Admin</li>
        <li><a href="../../index.php" id="menu">Menu</a></li>
        <li><a href="#" id="type">Analyse</a></li>
        <li><a class="active" href="ajout_pok.php" id="abonnement">Pokemons</a></li>
        <li><a href="#" id="contact">Commandes</a></li>
        <li><a href="../deconnexion.php" id="deconnexion">Déconnexion</a></li>
    </ul>
</section>

<main class="col overflow-auto h-100 w-100">
    <a class="btn btn-dark btn-sm" href="ajout_pok.php">← Retour</a><br><br>

    <h4>Modifier Pokemon</h4>

    <?php
        // Vérification si le formulaire de modification a été soumis
        if (isset($_POST['modifier'])) {
            // Récupération des nouvelles valeurs du formulaire
            $id = $_POST['id']; // Nouvel ID
            $nom = htmlentities($_POST['nom'], ENT_QUOTES, 'UTF-8');
            $type_1 = htmlentities($_POST['type_1'], ENT_QUOTES, 'UTF-8');
            $type_2 = htmlentities($_POST['type_2'], ENT_QUOTES, 'UTF-8');
            $generation = $_POST['generation'];
            $prix = $_POST['prix'];
            $discount = $_POST['discount'];
            $description = htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8');
            $quantite = $_POST['quantité'];
            $imageFilePath = $pokedex->image;

            // Gestion de l'image si une nouvelle image a été téléchargée
            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                $imageFilePath = '../../img/' . uniqid() . $image;
                move_uploaded_file($_FILES['image']['tmp_name'], $imageFilePath);
            }

            // Préparation des données à envoyer via PUT
            $data = [
                'id' => $id,
                'nom' => $nom,
                'type_1' => $type_1,
                'type_2' => $type_2,
                'generation' => $generation,
                'prix' => $prix,
                'discount' => $discount,
                'description' => $description,
                'quantité' => $quantite,
                'image' => $imageFilePath
            ];

            // Initialisation de cURL pour la requête PUT
            $putUrl = 'http://127.0.0.1:8000/api/pokedex/' . $currentId . '/';
            $ch = curl_init($putUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            // Exécution de la requête
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Gestion de la réponse
            if ($httpCode == 200) {
                header('Location: ajout_pok.php');
                exit;
            } else {
                echo "<div class='alert alert-danger'>Erreur lors de la modification du Pokémon via l'API. Réponse : $response</div>";
            }
        }
    ?>

    <!-- Formulaire de modification -->
    <form method="post" enctype="multipart/form-data">
        <label class="form-label">ID :</label>
        <input type="text" class="form-control" name="id" value="<?= $pokedex->id ?>" required>

        <label class="form-label">Nom :</label>
        <input type="text" class="form-control" name="nom" value="<?= $pokedex->nom ?>" required>

        <label class="form-label">Type 1 :</label>
        <input type="text" class="form-control" name="type_1" value="<?= $pokedex->type_1 ?>" required>

        <label class="form-label">Type 2 :</label>
        <input type="text" class="form-control" name="type_2" value="<?= $pokedex->type_2 ?>">

        <label class="form-label">Génération :</label>
        <input type="number" class="form-control" step="1" name="generation" min="1" value="<?= $pokedex->generation ?>" required>

        <label class="form-label">Prix :</label>
        <input type="number" class="form-control" step="0.1" name="prix" min="0" value="<?= $pokedex->prix ?>" required>

        <label class="form-label">Discount :</label>
        <input type="range" value="<?= $pokedex->discount ?>" class="form-control" name="discount" min="0" max="90">

        <label class="form-label">Description (maximum 255 caractères) :</label>
        <textarea class="form-control" name="description"><?= $pokedex->description ?></textarea>

        <label class="form-label">Quantité :</label>
        <input type="number" class="form-control" name="quantité" min="0" value="<?= $pokedex->quantite ?>" required>

        <label class="form-label">Image :</label>
        <input type="file" accept="image/png, image/jpeg, image/jpg" class="form-control" name="image">

        <!-- Affichage de l'image actuelle -->
        <?php if (!empty($pokedex->image)) : ?>
            <img width="250" class="img img-fluid" src="../../img/<?= $pokedex->image ?>"><br>
        <?php endif; ?>

        <input type="submit" value="Modifier produit" class="btn btn-primary my-2" name="modifier">
    </form>
</main>
