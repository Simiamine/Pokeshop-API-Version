<?php
session_start();
// Vérification du statut de l'utilisateur
if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
    header('Location: ../../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        $id = $_POST['id'];  // ID fourni par l'utilisateur
        $nom = htmlentities($_POST['nom'], ENT_QUOTES, 'UTF-8');
        $type_1 = htmlentities($_POST['type_1'], ENT_QUOTES, 'UTF-8');
        $type_2 = htmlentities($_POST['type_2'], ENT_QUOTES, 'UTF-8');
        $generation = $_POST['generation'];
        $legendaire = isset($_POST['légendaire']) ? true : false; // Booléen pour légendaire
        $prix = $_POST['prix'];
        $discount = $_POST['discount'];

        // Limitation stricte de la description à 250 caractères
        $description = htmlentities(substr($_POST['description'], 0, 250), ENT_QUOTES, 'UTF-8');
        $quantite = $_POST['quantite'];

        // Assignation d'une image par défaut
        $filename = 'pokeball.png';

        // Vérification si une image a été téléchargée
        if (!empty($_FILES['image']['name'])) {
            // Génération d'un nom unique pour l'image et ajout de l'extension de l'image
            $image = $_FILES['image']['name'];
            $filename = uniqid() . $image;
            $destination = '../../img/' . $filename; // Chemin corrigé

            // Déplacement de l'image téléchargée dans le dossier de destination
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                echo '<div class="alert alert-danger" role="alert">Erreur lors du téléchargement de l\'image.</div>';
                exit; // Arrêter le processus si l'image ne peut pas être déplacée
            }
        }

        // Préparation des données à envoyer à l'API
        $data = [
            'id' => $id, // Utilisation de l'ID fourni par l'utilisateur
            'nom' => $nom,
            'type_1' => $type_1,
            'type_2' => $type_2,
            'generation' => $generation,
            'legendaire' => $legendaire,
            'prix' => $prix,
            'discount' => $discount,
            'description' => $description,
            'quantite' => $quantite,
            'image' => $filename, // Utilisation de $filename
        ];

        // Envoi des données à l'API via POST avec cURL
        $url = 'http://127.0.0.1:8000/api/pokedex/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Vérification de la réponse de l'API
        if ($httpCode == 201) { // 201 Created
            header('location: ajout_pok.php'); // Redirection si succès
        } else {
            // Affichage d'un message d'erreur si l'insertion a échoué
            echo '<div class="alert alert-danger" role="alert">Erreur lors de l\'ajout du Pokémon via l\'API. Réponse : ' . $response . '</div>';
        }
    }
    ?>

    <!-- Début du formulaire pour ajouter un produit -->
    <form method="post" enctype="multipart/form-data">
        <label class="form-label">ID</label>
        <input type="text" class="form-control" step="1" name="id" required>

        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" required>

        <label class="form-label">Type 1</label>
        <input type="text" class="form-control" name="type_1" required>

        <label class="form-label">Type 2</label>
        <input type="text" class="form-control" name="type_2">

        <label class="form-label">Génération</label>
        <input type="number" class="form-control" step="1" name="generation" min="0">

        <label class="form-label">Légendaire</label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="légendaire" value="oui">
            <label class="form-check-label" for="légendaire">Oui</label>
        </div>

        <label class="form-label">Prix</label>
        <input type="number" class="form-control" step="0.01" name="prix" min="0" required>

        <label class="form-label">Discount&nbsp&nbsp</label><output name="discountOutput" for="discount">0</output>% 
        <input type="range" value="0" class="form-control" name="discount" min="0" max="90" oninput="discountOutput.value = discount.value">

        <label class="form-label">Description (250 caractères maximum)</label>
        <textarea class="form-control" name="description" maxlength="250" required></textarea>

        <label class="form-label">Quantité</label>
        <input type="number" class="form-control" name="quantite" min="0" required>

        <label class="form-label">Image</label>
        <input type="file" accept="image/png, image/jpeg, image/jpg" class="form-control" name="image">

        <input type="submit" value="Ajouter produit" class="btn btn-primary my-2" name="ajouter">
    </form>
</main>
</html>