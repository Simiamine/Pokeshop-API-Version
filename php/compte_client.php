<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client</title>
    <script src="../js/pokemon.js" defer></script>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style_profil.css" rel="stylesheet">
    </head>

    <body>
            <header class = header-home>
            <div class = "contenair">     
            <section id="header">
        <div class="logo">
            <a href="../index.php"><img src="../img/icon.png" alt="pokeball" class = "logo" width="50"></a>
        </div>

        <?php if (isset($_SESSION['user_statut']) && $_SESSION['user_statut'] == 'client'): ?>
        <ul id="navbar">
        <li>Bonjour, <?= htmlspecialchars($_SESSION['user_name']); ?></li>
        <li><a  href="../index.php" id="menu">Menu</a></li>
        <li><a  href="#" id="type">Catalogue</a></li>
        <li><a href="pokedex.php" id="type">Pokedex</a></li>
        <li><a class="active" href="compte_client.php" id="compte">Compte</a></li>
        <li><a href="deconnexion.php" id="deconnexion">Déconnexion</a></li>
        <li><a id="panier" href="#"><i class="fa-solid fa-bag-shopping fa-xl"></i></a></li>
        </ul>
        <?php endif; ?>
            </section>

<br>
<main class ="main">
<div class="contenair d-flex"> 
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
                    <h2>Bienvenue sur votre espace Client </h2>
                    <hr/>
                    <h4><strong>Information personnel :</strong></h4>
                    <div class="container">
                        <div class="col-md-12">
            
                        <?php
                        require '../include/databaseconnect.php';
                       
                        if (isset($_SESSION['user_id'])) {  // Vérifie si l'utilisateur est connecté.
                            $requete = $bdd->prepare("SELECT * FROM utilisateur WHERE id = :id");
                            $requete->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
                            $requete->execute();
                            $utilisateur = $requete->fetch();

                            // Vérifie si des informations ont été trouvées pour cet utilisateur.
                            if ($utilisateur) {
                                echo "<p>Votre prénom est : " . htmlspecialchars($utilisateur['prenom']) . "</p>";
                                echo "<p>Votre nom est : " . htmlspecialchars($utilisateur['nom']) . "</p>";
                                echo "<p>Votre email est : " . htmlspecialchars($utilisateur['email']) . "</p>";
                                echo "<p> Votre date de naissance : " . htmlspecialchars($utilisateur['dateNaissance']) . "</p>";
                                echo "<p> Votre numéro de téléphone : " . htmlspecialchars($utilisateur['telephone']) . "</p>";
                            } else {
                                echo "<p>Aucune information disponible pour cet utilisateur.</p>";
                            }
                        } else {
                            echo "<p>Utilisateur non connecté.</p>";
                        }
?>

                        <p>Vous avez la possibilité de changer votre mot de passe : <button type="button" data-toggle="modal" data-target="#change_password">Changer mon mot de passe</button> </p>


                          <!-- Modalité pour changer le mot de passe 
                            une pop up apparait avec un formulaire -->
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
                                    <form action="change_mdp.php" method="POST">
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
                                        <!-- en appuyant sur envoyer, les données sont envoyé a change_mdp.php, les données sont alors vérifié-->
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






                <?php
                           
                ?>


                    <div>
                    
                </div>
</main></main>

