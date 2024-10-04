<?php
session_start();
$_SESSION['finalPrice'] = 0;

// Fonction de conversion d'euros en nombre
function convertirEuroEnNombre($montant) {
    $montantNettoye = str_replace(['€', ' '], '', $montant);
    return $montantNettoye;
}

// Calcul du total du panier
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
    foreach ($_SESSION['panier'] as $key => $produit) {
        $result = convertirEuroEnNombre($produit->prixApresRemise) * $produit->quantite;
        $_SESSION['finalPrice'] += $result;
    }
}

// Initialiser le panier s'il n'existe pas encore
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}
$total = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier | Pokeshop</title>
    
    <!-- Liens CSS et JS -->
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/valider_commande.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
    
</head>

<body>

<!-- Inclusion du header -->
<?php include_once('../../include/header.php'); ?>

<script>
    $("#panier").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>
<style>
        body {
            background-color: #f0f0f0; /* Gris clair */
            min-height: 100vh; /* Prend toute la hauteur de l'écran */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

    </style>
<div class="form-modal">
    <div id="commande">
        <form action="../../php/commande_vers_bdd.php" method="POST">
            <label for="prenom">Prénom:</label>
            <input id="prenom" type="text" name="prenom" placeholder="Prénom" maxlength="50" required/> <br>
            
            <label for="nom">Nom:</label>
            <input id="nom" type="text" name="nom" placeholder="Nom" maxlength="50" required/> <br>
            
            <label for="email">Adresse mail:</label>
            <input id="email" type="email" name="email" placeholder="Adresse mail" maxlength="50" required/> <br>
            
            <label for="tel">Numéro de téléphone:</label>
            <input id="tel" type="tel" name="telephone" placeholder="Numéro de téléphone" maxlength="30" required/> <br>
            
            <label for="adresse">Adresse de livraison:</label>
            <input id="adresse" type="text" name="adresse" placeholder="Adresse de livraison" maxlength="255" required/> <br>

            <label for="ville">Ville:</label>
            <input id="ville" type="text" name="ville" placeholder="Ville" maxlength="100" required/> <br>
            
            <label for="code_postal">Code postal:</label>
            <input id="code_postal" type="text" name="code_postal" placeholder="Code postal" maxlength="10" required/> <br>

            <fieldset>
                <legend>Moyen de livraison:</legend>
                <label>
                    <input type="radio" name="livraison" required> Standard
                </label><br>
                <label>
                    <input type="radio" name="livraison"> Relais
                </label><br>
                <label>
                    <input type="radio" name="livraison"> Express
                </label><br>
            </fieldset>

            <fieldset>
                <legend>Moyen de paiement:</legend>
                <label>
                    <input type="radio" name="payment_method" value="cb" required> Carte Bancaire
                    <img src="../../img/CB.png" alt="CB" style="height:30px;">
                </label><br>
                <label>
                    <input type="radio" name="payment_method" value="mastercard"> MasterCard
                    <img src="../../img/mastercard.png" alt="MasterCard" style="height:30px;">
                </label><br>
                <label>
                    <input type="radio" name="payment_method" value="paypal"> PayPal
                    <img src="../../img/paypal.png" alt="PayPal" style="height:30px;">
                </label><br>
            </fieldset>
            
            <button class="btn-submit" type="submit" title="Passer commande">Valider ma commande</button>
        </form>
    </div>
</div>   

<!-- Inclusion du footer -->
<?php include_once('../../include/footer.php'); ?>

</body>
</html>
