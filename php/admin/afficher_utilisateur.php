<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="../../css/bootstrap.css" rel="stylesheet">
</head>

<?php include_once('../../include/header.php'); ?>
<script>
    $("#utilisateur").addClass("active");  // Fonction pour mettre la class "active" sur l'onglet Utilisateurs
</script>

<body>
<div class="container mt-5">
    <h1>Gestion des utilisateurs</h1>

    <!-- Filtre pour sélectionner le type d'utilisateur -->
    <div class="form-group d-flex align-items-center">
        <label for="statut-filter" class="mr-2">Filtrer par statut :</label>
        <select id="statut-filter" class="form-control w-25">
            <option value="Tous">Tous</option>
            <option value="client">Client</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <!-- Tableau pour afficher les utilisateurs -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Date de naissance</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="utilisateurs-table-body">
            <!-- Les utilisateurs seront injectés ici via JavaScript -->
        </tbody>
    </table>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet utilisateur ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirm-delete-btn">Supprimer</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour afficher le message de succès -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Succès</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Utilisateur supprimé avec succès !
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="success-modal-btn">OK</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
let utilisateurs = [];
let utilisateurIdToDelete = null;

// Fonction pour récupérer tous les utilisateurs depuis l'API
function fetchUtilisateurs() {
    fetch('http://127.0.0.1:8000/api/utilisateurs/')
        .then(response => response.json())
        .then(data => {
            utilisateurs = data; // Stocker tous les utilisateurs récupérés
            afficherUtilisateurs('Tous'); // Afficher par défaut tous les utilisateurs
        })
        .catch(error => console.error('Erreur lors de la récupération des utilisateurs :', error));
}

// Fonction pour afficher les utilisateurs filtrés
function afficherUtilisateurs(filtreStatut) {
    const tbody = document.getElementById('utilisateurs-table-body');
    tbody.innerHTML = ''; // Vider le tableau avant de l'actualiser

    utilisateurs.forEach(utilisateur => {
        if (filtreStatut === 'Tous' || utilisateur.statut === filtreStatut) {
            const tr = document.createElement('tr');

            tr.innerHTML = `
                <td>${utilisateur.prenom}</td>
                <td>${utilisateur.nom}</td>
                <td>${utilisateur.email}</td>
                <td>${utilisateur.telephone}</td>
                <td>${utilisateur.date_naissance}</td>
                <td>${utilisateur.statut}</td>
                <td>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${utilisateur.id}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
        }
    });

    // Ajout des gestionnaires d'événements pour les boutons de suppression
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            utilisateurIdToDelete = this.getAttribute('data-id'); // Stocker l'ID de l'utilisateur à supprimer
            $('#confirmDeleteModal').modal('show'); // Afficher le modal de confirmation
        });
    });
}

// Filtrer les utilisateurs en fonction du statut sélectionné
document.getElementById('statut-filter').addEventListener('change', function() {
    const filtreStatut = this.value;
    afficherUtilisateurs(filtreStatut);
});

// Fonction pour supprimer un utilisateur via l'API
document.getElementById('confirm-delete-btn').addEventListener('click', function() {
    if (utilisateurIdToDelete) {
        fetch(`http://127.0.0.1:8000/api/utilisateurs/${utilisateurIdToDelete}/`, {
            method: 'DELETE'
        })
        .then(response => {
            if (response.ok) {
                $('#confirmDeleteModal').modal('hide'); // Fermer le modal de confirmation
                $('#successModal').modal('show'); // Afficher le modal de succès
            } else {
                alert('Erreur lors de la suppression de l\'utilisateur');
            }
        })
        .catch(error => console.error('Erreur lors de la suppression :', error));
    }
});

// Gestion du clic sur le bouton OK du modal de succès pour rafraîchir la page
document.getElementById('success-modal-btn').addEventListener('click', function() {
    location.reload(); // Rafraîchir la page
});

// Charger les utilisateurs lors du chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    fetchUtilisateurs();
});
</script>

</body>
</html>
