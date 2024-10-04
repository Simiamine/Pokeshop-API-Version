<?php 
session_start();

// Vérification que l'utilisateur est bien admin
if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
    header('Location: ../../index.php');
    exit;
}

// Récupération de l'ID de la commande depuis l'URL
if (!isset($_GET['id_commande']) || !is_numeric($_GET['id_commande'])) {
    die("Commande non valide.");
}

$id_commande = $_GET['id_commande'];

// Récupération des détails de la commande via l'API
$commande_url = "http://127.0.0.1:8000/api/commandes/{$id_commande}/";
$commande_data = file_get_contents($commande_url);
$commande = json_decode($commande_data, true);

if (!$commande) {
    die("Erreur lors de la récupération des données de la commande.");
}

// Récupération du client à partir de l'utilisateur associé à la commande
if (isset($commande['utilisateur']) && !empty($commande['utilisateur'])) {
    $utilisateur_id = $commande['utilisateur'];
    $utilisateur_url = "http://127.0.0.1:8000/api/utilisateurs/{$utilisateur_id}/";
    $utilisateur_data = file_get_contents($utilisateur_url);
    $utilisateur = json_decode($utilisateur_data, true);

    // Vérification que les informations du client sont valides
    $prenom = isset($utilisateur['prenom']) ? htmlspecialchars($utilisateur['prenom']) : 'Inconnu';
    $nom = isset($utilisateur['nom']) ? htmlspecialchars($utilisateur['nom']) : 'Inconnu';
} else {
    $prenom = 'Inconnu';
    $nom = 'Inconnu';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de la commande</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .commande-details {
            margin-top: 30px;
        }
        .commande-details h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .commande-summary {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }
        .produit-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .produit-info {
            display: flex;
            align-items: center;
        }
        .produit-info h5 {
            margin-bottom: 0;
        }
        .produit-info span {
            font-size: 0.9em;
            color: #888;
        }
        .produit-quantite {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
    </style>
    <script>

    // Fonction pour mettre à jour le statut de la commande via une requête PATCH
    function updateStatutCommande(id_commande) {
        const statut = document.getElementById('statut-commande').value;
        
        // Préparer les données pour la requête PATCH
        const data = {
            'statut': statut
        };

        console.log("Envoi des données au serveur :", data); // Log pour voir les données envoyées

        // Faire la requête PATCH vers l'API
        fetch(`http://127.0.0.1:8000/api/commandes/${id_commande}/update-livraison/`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP : ${response.status}`);
            }
            return response.json();  // Si tout s'est bien passé, la requête est traitée ici
        })
        .then(data => {
            console.log("Réponse du serveur :", data); // Log pour voir la réponse du serveur
            alert('Statut de la commande mis à jour avec succès.');  // Afficher le succès sans vérifier `data.success`
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la communication avec le serveur. Détails : ' + error.message);
        });
    }

    </script>

</head>
<body>

    <?php include_once('../../include/header.php'); ?>

    <div class="container commande-details">
        <h2>Détail de la commande #<?= htmlspecialchars($commande['id']) ?></h2>

        <div class="commande-summary">
            <p><strong>Client :</strong> <?= htmlspecialchars($commande['utilisateur_id']) ?></p> <!-- Affichage du client -->
            <p><strong>Numéro de commande :</strong> <?= htmlspecialchars($commande['numero_commande']) ?></p>
            <p><strong>Adresse de livraison :</strong> <?= htmlspecialchars($commande['ville']) ?>, <?= htmlspecialchars($commande['code_postal']) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($commande['date_creation']) ?></p>
            <p><strong>Total :</strong> <?= htmlspecialchars($commande['total']) ?>€</p>
            
            <!-- Ajout de la liste déroulante pour modifier le statut de la commande -->
            <p><strong>Statut de la commande :</strong> 
                <select id="statut-commande" onchange="updateStatutCommande(<?= $id_commande ?>)">
                    <option value="EN_TRAITEMENT" <?= $commande['statut'] == 'EN_TRAITEMENT' ? 'selected' : '' ?>>En traitement</option>
                    <option value="EXPEDIEE" <?= $commande['statut'] == 'EXPEDIEE' ? 'selected' : '' ?>>Expédiée</option>
                    <option value="LIVREE" <?= $commande['statut'] == 'LIVREE' ? 'selected' : '' ?>>Livrée</option>
                    <option value="ANNULEE" <?= $commande['statut'] == 'ANNULEE' ? 'selected' : '' ?>>Annulée</option>
                </select>
            </p>
        </div>

        <hr>

        <h3>Produits commandés</h3>

        <?php 
        // Vérification des détails de la commande
        if (!empty($commande['details'])) { 
            foreach ($commande['details'] as $detail) { ?>
                <div class="produit-card">
                    <div class="produit-info">
                        <div>
                            <h5><?= htmlspecialchars($detail['produit_nom']) ?></h5>
                            <span>Quantité : <?= htmlspecialchars($detail['quantite']) ?></span><br>
                        </div>
                    </div>
                </div>
        <?php 
            } 
        } else { ?>
            <p>Données insuffisantes pour cette commande.</p>
        <?php 
        } 
        ?>
    </div>

</body>
</html>
