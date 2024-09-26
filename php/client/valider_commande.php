<?php
function convertirEuroEnNombre($montant) {
    $montantNettoye = str_replace(['€', ' '], '', $montant);


    return $montantNettoye;
}

session_start();
$_SESSION['finalPrice'] = 0;
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
    foreach ($_SESSION['panier'] as $key=>$produit) {
        $result = convertirEuroEnNombre($produit->prixApresRemise) * $produit->quantite;
        $_SESSION['finalPrice'] += $result;
        //echo $result;
        
    }
    //echo $_SESSION['finalPrice'];
    
} 

// Initialiser le panier s'il n'existe pas encore
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

$total = 0;


?>
<?php 
  
        
    




?>

<!DOCTYPE html>
<html lang="fr">




</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier | Pokeshop</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- j'ai modifié -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/valider_commande.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
</head>


<?php include_once('../../include/header.php'); ?>

<script>
    $("#panier").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>

<body>
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
                    <input type="radio" name="livraison" > relais
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
            
            <button  class="btn-submit" title="Passer commande" onclick="location.href='../commande_vers_bdd.php';">Valider ma commande</button>
        </form>
    </div>
</div>   
</body>

