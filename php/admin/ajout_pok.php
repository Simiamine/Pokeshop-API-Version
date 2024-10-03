<?php  
    session_start();
    
    // Vérification de l'état d'admin
    if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
        header('Location: ../../index.php');
        exit;
    }

    // URL de l'API pour récupérer la liste des pokémons
    $api_url = 'http://127.0.0.1:8000/api/pokedex/';

    // Initialiser cURL pour faire la requête vers l'API
    $curl = curl_init($api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Retourner la réponse plutôt que l'afficher directement
    curl_setopt($curl, CURLOPT_HTTPGET, true);  // Faire une requête GET

    // Exécuter la requête et récupérer la réponse
    $response = curl_exec($curl);

    // Vérifier les erreurs de cURL
    if (curl_errno($curl)) {
        echo 'Erreur cURL : ' . curl_error($curl);
    } else {
        // Décoder la réponse JSON en tableau associatif PHP
        $pokemons = json_decode($response, true);
    }

    // Fermer cURL
    curl_close($curl);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des Pokémons</title>
        <script src="../js/pokemon.js" defer></script>
        <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../../css/style2.css">
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="icon" type="image/png" href="../../img/icon.png"/>
    </head>

    <?php include_once('../../include/header.php'); ?>
    <script>
        $("#pokemon").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
    </script>

    <body>
        <div class="mt-3 container-fluid pb-3 flex-grow-1 d-flex flex-column flex-sm-row overflow-auto">
            <div class="row flex-grow-sm-1 flex-grow-0 container-fluid">
                <main class="col overflow-auto h-100 w-100">
                    <div class="container py-2">
                        <h2>Liste des Pokémons</h2>
                        <a href="ajout_produit_pokemon.php" class="btn btn-primary">Ajouter produit</a>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>1er type</th>
                                    <th>2ème type</th>
                                    <th>Légendaire</th>
                                    <th>Prix</th>
                                    <th>Discount</th>
                                    <th>Description</th>
                                    <th>Quantité</th>
                                    <th>Image</th>
                                    <th>Opérations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Vérifier que des pokémons ont été récupérés depuis l'API
                                if (!empty($pokemons)) {
                                    // Parcourir chaque pokémon récupéré de l'API et l'afficher dans le tableau
                                    foreach ($pokemons as $pokemon) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($pokemon['nom']) . "</td>";
                                        echo "<td>" . htmlspecialchars($pokemon['type_1']) . "</td>";
                                        echo "<td>" . ($pokemon['type_2'] !== null ? htmlspecialchars($pokemon['type_2']) : '') . "</td>";
                                        echo "<td>" . ($pokemon['legendaire'] ? 'Oui' : 'Non') . "</td>";
                                        echo "<td>" . htmlspecialchars($pokemon['prix']) . "€</td>";
                                        echo "<td>" . htmlspecialchars($pokemon['discount']) . "%</td>";
                                        echo "<td>" . htmlspecialchars($pokemon['description']) . "</td>";
                                        echo "<td>" . htmlspecialchars($pokemon['quantite']) . "</td>";
                                        echo "<td><img src='../../img/" . htmlspecialchars($pokemon['image']) . "' alt='Image du pokemon' width='90'></td>";
                                        echo "<td>
                                            <a class='btn btn-primary' href='modification_pok.php?id=" . $pokemon['id'] . "'>Modifier</a>
                                            <a class='btn btn-danger' href='supp_produit.php?id=" . $pokemon['id'] . "' onclick=\"return confirm('Voulez-vous vraiment supprimer le produit " . addslashes($pokemon['nom']) . " ?')\">Supprimer</a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>Aucun Pokémon trouvé.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
