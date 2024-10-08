<?php  
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client</title>
    <script src="../../js/pokemon.js" defer></script>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link href="../../css/style_profil.css" rel="stylesheet">
    </head>

    <?php include_once('../../include/header.php'); ?>
    <script>
        $("#pokemon").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
    </script>

<br>
<main class ="main">
<div class="contenair d-flex"> 
<aside class="flex-grow-1">
    <div class="bg-light border rounded-3 p-1 h-100 sticky-top">
        <ul class="nav nav-pills flex-sm-column flex-row mb-auto justify-content-between text-truncate">
            <li class="my-1">
                <a href="compte_client.php" class="nav-link px-2 text-truncate">
                    <i class="bi bi-layout-text-sidebar-reverse"></i>
                    <span class="d-none d-sm-inline">Mon profil</span>
                </a>
            </li>
            <li class="my-1 nav-item">
                <a href="commande.php" class="nav-link px-2 text-truncate"><i class="bi bi-card-text fs-5"></i>
                    <span class="d-none d-sm-inline">Commandes</span> </a>
            </li>
            <li class="my-1">
                <a href="politique.php" class="nav-link px-2 text-truncate"><i class="bi bi-people fs-5"></i>
                    <span class="d-none d-sm-inline">Politiques</span> </a>
        </li>
        </ul>
    </div>
</aside>

<main class="flex-grow-4">
    <h2>Liste de mes Commandes</h2>
    <table class="table table-striped table-hover">
        <?php
        if (isset($_SESSION['user_id'])) {  // Vérifie si l'utilisateur est connecté.
            $user_id = $_SESSION['user_id'];
            $url = "http://127.0.0.1:8000/api/utilisateurs/{$user_id}/commandes/";

            // Utilisation de file_get_contents pour récupérer les données de l'API
            $commande_data = file_get_contents($url);
            $commandes = json_decode($commande_data, true);

            // Vérifie si des commandes ont été trouvées pour cet utilisateur.
            if ($commandes && count($commandes) > 0) {
                echo "<table class='table table-striped table-hover'>";
                echo "<thead><tr><th>Numéro commande</th><th>Adresse de livraison</th><th>Ville</th><th>Code Postal</th><th>Total</th><th>Date</th><th>Opération</th></tr></thead><tbody>";
                
                // Boucle à travers les commandes pour les afficher
                foreach ($commandes as $commande) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($commande['numero_commande']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['adresse_livraison']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['ville']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['code_postal']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['total']) . "€</td>";
                    echo "<td>" . htmlspecialchars($commande['date_creation']) . "</td>";
                    echo "<td><a class='btn btn-primary btn-sm' href='facture.php?id=" . htmlspecialchars($commande['id']) . "'>Afficher facture</a></td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<p>Aucune commande passée.</p>";
            }
        } else {
            echo "<p>Veuillez vous connecter pour voir vos commandes.</p>";
        }
        ?>
    </table>
</main>
</div>
</main>
</html>
