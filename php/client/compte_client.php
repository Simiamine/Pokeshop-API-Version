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
<main class="main">
<div class="container d-flex"> 
<aside class="flex-grow-1">
    <div class="bg-light border rounded-3 p-1 h-100 sticky-top">
        <ul class="nav nav-pills flex-sm-column flex-row mb-auto justify-content-between text-truncate">
            <li class="my-1">
                <a href="compte_client.php" class="nav-link px-2 text-truncate">
                    <i class="bi bi-layout-text-sidebar-reverse"></i></i>
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
    <div class="bg-light border rounded-3 p-3">
        <h2>Bienvenue sur votre espace Client</h2>
        <hr/>
        <h4><strong>Informations personnelles :</strong></h4>
        <div class="container">
            <div class="col-md-12">
                <?php
                // Affichage des informations utilisateur stockées dans la session
                echo "<p>Prénom : " . htmlspecialchars($_SESSION['user_prenom']) . "</p>";
                echo "<p>Nom : " . htmlspecialchars($_SESSION['user_nom']) . "</p>";
                echo "<p>Email : " . htmlspecialchars($_SESSION['user_email']) . "</p>";

                // Affichage conditionnel pour les informations supplémentaires
                if (isset($_SESSION['user_telephone'])) {
                    echo "<p>Numéro de téléphone : " . htmlspecialchars($_SESSION['user_telephone']) . "</p>";
                }

                if (isset($_SESSION['user_date_naissance'])) {
                    echo "<p>Date de naissance : " . htmlspecialchars($_SESSION['user_date_naissance']) . "</p>";
                }
                ?>

            <p>
                <button type="button" class="btn btn-primary">Modifier mes informations</button>
            </p>

            <p>Vous avez la possibilité de changer votre mot de passe : 
                <button type="button" data-toggle="modal" data-target="#change_password">Changer mon mot de passe</button> 
            </p>

            <!-- Modal pour changer le mot de passe -->
            <div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Changer mon mot de passe</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="../change_mdp.php" method="POST">
                                <label for='current_password'>Mot de passe actuel</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="form-control" required />
                                <br />
                                <label for='new_password'>Nouveau mot de passe</label>
                                <input type="password" id="new_password" name="new_password" class="form-control"
                                    required />
                                <br />
                                <label for='new_password_retype'>Re tapez le nouveau mot de passe</label>
                                <input type="password" id="new_password_retype" name="new_password_retype"
                                    class="form-control" required />
                                <br />
                                <!-- en appuyant sur envoyer, les données sont envoyées à change_mdp.php pour vérification -->
                                <button type="submit" class="btn btn-success">Sauvegarder</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
                integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
            </script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
            </script>
            <div>
        </div>
    </div>
</main>
</main>
