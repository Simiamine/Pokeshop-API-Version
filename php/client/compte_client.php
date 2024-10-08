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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modifyInfoModal" id="openModifyInfoModal">Modifier mes informations</button>
            </p>

            <p>Vous avez la possibilité de changer votre mot de passe : 
                <button type="button" data-toggle="modal" data-target="#change_password">Changer mon mot de passe</button> 
            </p>

            <!-- Modal pour modifier les informations -->
            <div class="modal fade" id="modifyInfoModal" tabindex="-1" role="dialog" aria-labelledby="modifyInfoModalTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier mes informations</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modifyInfoForm">
                                <label for="prenom">Prénom</label>
                                <input type="text" id="prenom" name="prenom" class="form-control" required>
                                <br />
                                <label for="nom">Nom</label>
                                <input type="text" id="nom" name="nom" class="form-control" required>
                                <br />
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                                <br />
                                <label for="telephone">Téléphone</label>
                                <input type="text" id="telephone" name="telephone" class="form-control">
                                <br />
                                <label for="date_naissance">Date de naissance</label>
                                <input type="date" id="date_naissance" name="date_naissance" class="form-control">
                                <br />
                                <button type="button" class="btn btn-success" id="submitModifyInfo">Sauvegarder</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal pour changer le mot de passe -->
            <div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Changer mon mot de passe</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulaire de changement de mot de passe -->
                            <form id="change-password-form">
                                <label for="new_password">Nouveau mot de passe</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required />
                                <br />
                                <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required />
                                <br />
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
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
        </div>
    </div>
</main>
</main>

<script>
// Fonction pour récupérer les informations utilisateur via une requête GET à l'API
document.getElementById('openModifyInfoModal').addEventListener('click', function() {
    const userId = <?= $_SESSION['user_id']; ?>;
    const url = `http://127.0.0.1:8000/api/utilisateurs/${userId}/`;

    fetch(url)
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Erreur lors de la récupération des informations : ' + data.error);
        } else {
            // Remplir le formulaire avec les informations récupérées
            document.getElementById('prenom').value = data.prenom;
            document.getElementById('nom').value = data.nom;
            document.getElementById('email').value = data.email;
            document.getElementById('telephone').value = data.telephone;
            document.getElementById('date_naissance').value = data.date_naissance;
        }
    })
    .catch(error => console.error('Erreur lors de la récupération des informations :', error));
});

// Envoi des informations modifiées via une requête PATCH
document.getElementById('submitModifyInfo').addEventListener('click', function() {
    const userId = <?= $_SESSION['user_id']; ?>;
    const url = `http://127.0.0.1:8000/api/utilisateurs/${userId}/`;

    const data = {
        prenom: document.getElementById('prenom').value,
        nom: document.getElementById('nom').value,
        email: document.getElementById('email').value,
        telephone: document.getElementById('telephone').value,
        date_naissance: document.getElementById('date_naissance').value
    };

    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Erreur lors de la modification : ' + data.error);
        } else {
            alert('Informations mises à jour avec succès !');
            location.reload(); // Recharger la page pour afficher les nouvelles informations
        }
    })
    .catch(error => console.error('Erreur :', error));
});

// Gestion de la modification du mot de passe
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('change-password-form');
    const newPasswordField = document.getElementById('new_password');
    const confirmPasswordField = document.getElementById('confirm_password');

    form.addEventListener('submit', function(event) {
        event.preventDefault();  // Empêcher l'envoi par défaut du formulaire

        const newPassword = newPasswordField.value;
        const confirmPassword = confirmPasswordField.value;

        // Vérifier si les mots de passe correspondent
        if (newPassword !== confirmPassword) {
            alert('Les mots de passe ne correspondent pas.');
            return; // Arrêter l'exécution si les mots de passe ne sont pas identiques
        }

        // Si les mots de passe correspondent, faire une requête PATCH à l'API
        fetch('http://127.0.0.1:8000/api/utilisateurs/<?= $_SESSION['user_id']; ?>/', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                password: newPassword  // Le nouveau mot de passe envoyé à l'API
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la mise à jour du mot de passe.');
            }
            return response.json();
        })
        .then(data => {
            alert('Votre mot de passe a été mis à jour avec succès.');
            form.reset();  // Réinitialiser le formulaire
            $('#change_password').modal('hide');  // Fermer la modal
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour du mot de passe.');
        });
    });
});
</script>

</body>
</html>
