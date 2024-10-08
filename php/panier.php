<?php
session_start();

// Fonction pour convertir les prix en nombres utilisables
function convertirEuroEnNombre($montant) {
    $montantNettoye = str_replace(['€', ' '], '', $montant);
    return floatval($montantNettoye); // On s'assure que c'est un float
}

// Initialiser le panier s'il n'existe pas encore
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Supprimer un produit du panier
if (isset($_GET['supprimer']) && isset($_SESSION['panier'][$_GET['supprimer']])) {
    unset($_SESSION['panier'][$_GET['supprimer']]);
    header("Location: panier.php");
    exit();
}

// Mettre à jour la quantité d'un produit dans le panier
if (isset($_POST['update_qty'], $_POST['index'], $_POST['new_qty'])) {
    $index = $_POST['index'];
    $new_qty = $_POST['new_qty'];
    $_SESSION['panier'][$index]->quantite = $new_qty;
    exit();
}

// Calculer le total global
$total = 0;
foreach ($_SESSION['panier'] as $produit) {
    if (is_numeric($produit->prix) && is_numeric($produit->quantite)) {
        $total += convertirEuroEnNombre($produit->prix) * $produit->quantite;
    }
}

// Initialiser le total réduit
$total_reduit = $total;

if (isset($_POST['code_promo'])) {
    $code_promo = $_POST['code_promo'];

    if ($code_promo == '259325') {
        $reduction = 0.80; // 20% de réduction
    } elseif ($code_promo == 'MemePasUnPeu?') {
        $reduction = 0.75; // 25% de réduction
    } else {
        $reduction = 1; // Pas de réduction
    }
} else {
    $reduction = 1; // Pas de réduction par défaut
}

// Récupération des informations du panier via l'API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/api/pokedex/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

// Vérification de l'erreur de requête
if ($response === false) {
    echo 'Erreur lors de la requête API : ' . curl_error($ch);
    exit();
}

$data = json_decode($response);

// Vérification des erreurs de décodage JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Erreur lors du décodage JSON : ' . json_last_error_msg();
    exit();
}

curl_close($ch);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier | Pokeshop</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panier.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
</head>

<?php include_once('../include/header.php'); ?>

<script>
    $("#panier").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page

    // Fonction pour mettre à jour le panier et recalculer le total
    function majPanier(element) {
        var index = $(element).data('index');
        var newQty = parseInt($(element).val());
        var maxQty = parseInt($(element).attr('max'));

        // Vérifier que la nouvelle quantité ne dépasse pas le stock disponible
        if (newQty > maxQty) {
            alert('La quantité sélectionnée dépasse le stock disponible.');
            $(element).val(maxQty); // Remettre la quantité à la valeur maximale
            newQty = maxQty;
        }

        // Mettre à jour le panier en backend via AJAX
        $.post('panier.php', { update_qty: true, index: index, new_qty: newQty }, function() {
            recalculerTotal(); // Recalcul du total après mise à jour
        });
    }

    // Fonction pour recalculer le total global
    function recalculerTotal() {
        let total = 0;

        $('#panierTable tbody tr').each(function() {
            let prixUnitaire = parseFloat($(this).find('td:nth-child(3)').text().replace('€', ''));
            let quantite = parseInt($(this).find('input[name="new_qty"]').val());

            if (!isNaN(quantite) && quantite > 0) {
                let totalProduit = prixUnitaire * quantite;
                $(this).find('.totalProduit').text(totalProduit.toFixed(2) + '€');
                total += totalProduit;
            }
        });

        // Mettre à jour le total global avec ou sans réduction
        let reduction = <?php echo $reduction; ?>;
        $('.totalGlobal').text((total * reduction).toFixed(2) + '€');
    }

    $(document).ready(function() {
        recalculerTotal(); // Calcul initial au chargement de la page
    });    function verifierQuantitesAvantValidation() {
        let quantiteProbleme = false;

        $('#panierTable tbody tr').each(function() {
            const idPokemon = $(this).find('input[name="new_qty"]').data('idpok');
            const quantiteSelectionnee = parseInt($(this).find('input[name="new_qty"]').val());
            let quantiteDisponible = 0;

            // Vérifier la quantité disponible à partir des données API
            <?php foreach ($data as $pokemon): ?>
                if (idPokemon == "<?php echo $pokemon->id; ?>") {
                    quantiteDisponible = <?php echo $pokemon->quantite; ?>;
                }
            <?php endforeach; ?>

            // Si la quantité sélectionnée est supérieure à celle disponible
            if (quantiteSelectionnee > quantiteDisponible) {
                quantiteProbleme = true;
                alert(`La quantité sélectionnée pour ${$(this).find('input[name="new_qty"]').data('nom')} dépasse le stock disponible (${quantiteDisponible} en stock).`);
            }
        });

        // Si aucun problème n'est trouvé, on redirige vers la validation de la commande
        if (!quantiteProbleme) {
            window.location.href = 'client/valider_commande.php';
        }
    }

    $(document).ready(function() {
        // Gestion du clic sur le bouton "Valider ma commande"
        $('.btn-submit').on('click', function(event) {
            event.preventDefault(); // Empêche la redirection immédiate
            verifierQuantitesAvantValidation(); // Vérifie les quantités avant de valider
        });
    });
</script>

<body>
    <div class="container">
    <?php if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != 'client'): ?>
        <h1 class="titre">
            Pour profiter de notre avantage de fidélité, merci de vous connecter <a href="login.php" class="login.php">ici</a>
        </h1>
    <?php else: ?>
        <h1 class="titre">Panier</h1>
    <?php endif; ?>

    <?php if (empty($_SESSION['panier'])): ?>
        <div class="panier-vide">
            <h2>Votre panier est vide.</h2>
        </div>
    <?php else: ?>
        <div class="panier">
            <table id="panierTable">
                <thead>
                    <tr>
                        <th>ID du Pokémon</th>
                        <th>Nom du produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach ($_SESSION['panier'] as $index => $produit): 
                    // Obtenir la quantité maximale disponible pour ce produit à partir de l'API
                    $maxQuantite = 0;
                    foreach ($data as $pokemon) {
                        if ($pokemon->id == $produit->pokemon_id) {
                            $maxQuantite = $pokemon->quantite;
                            break;
                        }
                    }
                ?>
                <tr>
                    <td><?php echo $produit->pokemon_id; ?></td> <!-- ID du Pokémon -->
                    <td><?php echo $produit->nom; ?></td> <!-- Nom du produit -->
                    <td><?php echo $produit->prixApresRemise; ?></td> <!-- Prix après remise -->
                    <td>
                        <form class="qtyForm" data-index="<?php echo $index; ?>">
                            <input 
                                data-nom="<?php echo $produit->nom; ?>" 
                                data-index="<?php echo $index; ?>" 
                                data-idpok="<?php echo $produit->pokemon_id; ?>" 
                                onchange="majPanier(this)" 
                                type="number" 
                                name="new_qty" 
                                value="<?php echo $produit->quantite; ?>" 
                                min="1"
                                max="<?php echo $maxQuantite; ?>" <!-- Limite la quantité maximum -->
                            
                        </form>
                    </td>
                    <td class="totalProduit">
                        <?php echo number_format(convertirEuroEnNombre($produit->prixApresRemise) * intval($produit->quantite), 2); ?>€
                    </td>
                    <td>
                        <form action="panier.php" method="GET">
                            <input type="hidden" name="supprimer" value="<?php echo $index; ?>">
                            <button type="submit" class="btn-delete" title="Supprimer"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2" id="total" class="totalGlobal"><?php echo number_format($total_reduit, 2); ?>€</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Formulaire pour le code promo -->
        <div class="commande-form">
            <form action="panier.php" method="POST">
                <div class="form-group" style="display: inline-block; margin-right: 10px;">
                    <label for="code_promo">Code de promotion :</label>
                    <input type="text" id="code_promo" name="code_promo">
                </div>
                <button type="submit" id="apply-code-btn" class="btn btn-primary">Appliquer le code</button>
            </form>
        </div>

        <div class="commande-form" style="margin-top: 20px;">
            <a href="client/valider_commande.php" class="btn-submit" style="background-color: #52f436; color: black; border: none; padding: 15px 30px; text-align: center; text-decoration: none; font-size: 14px; cursor: pointer; border-radius: 5px;">Valider ma commande</a>
        </div>
    <?php endif; ?>
    </div>
</body>