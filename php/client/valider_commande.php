<?php
session_start();
$_SESSION['finalPrice'] = 0;

// Fonction de conversion d'euros en nombre
function convertirEuroEnNombre($montant) {
    $montantNettoye = str_replace(['€', ' '], '', $montant);
    return $montantNettoye;
}

// Calcul du total du panier
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $key => $produit) {
        $result = convertirEuroEnNombre($produit->prixApresRemise) * $produit->quantite;
        $_SESSION['finalPrice'] += $result;
    }
}

// Initialiser le panier s'il n'existe pas encore
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Vérification des informations de formulaire et envoi de la commande à l'API
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'utilisateur est connecté et possède un token JWT
    if (!isset($_SESSION['access_token'])) {
        echo "Erreur : Utilisateur non authentifié.";
        exit();
    }

    $access_token = $_SESSION['access_token'];

    // Récupérer les informations du formulaire
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $livraison = $_POST['livraison'];
    $payment_method = $_POST['payment_method'];

    // Préparer les détails de la commande (produits et quantités)
    $detailsCommande = [];
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $key => $produit) {
            if (isset($produit->pokemon_id)) {
                $detailsCommande[] = [
                    'produit' => $produit->pokemon_id,
                    'quantite' => $produit->quantite
                ];
            } else {
                echo "Erreur : Le produit n'a pas d'ID valide.";
                exit();
            }
        }
    } else {
        echo "Erreur : Le panier est vide.";
        exit();
    }

    // Préparer les données pour la commande et le paiement combinés
    $commandeData = [
        'commande' => [
            'adresse_livraison' => $adresse,
            'ville' => $ville,
            'code_postal' => $code_postal,
            'details' => $detailsCommande
        ],
        'montant' => $_SESSION['finalPrice']
    ];

    // URL de l'API pour créer la commande et traiter le paiement
    $url = 'http://127.0.0.1:8000/api/commande-paiement/';

    // Envoyer les données à l'API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $access_token
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($commandeData));

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Si la commande et le paiement sont traités avec succès
    if ($http_code == 201) {
        $commandeResponse = json_decode($response, true);
        
        // Redirection vers la page de validation de paiement
        if (isset($commandeResponse['stripe_url'])) {
            header('Location: ' . $commandeResponse['stripe_url']);
            exit();
        } else {
            echo "Erreur : L'URL de validation de paiement est manquante.";
        }
    } else {
        echo "Erreur lors de la création de la commande et du paiement.";
        echo "HTTP Code: $http_code";
        echo "Réponse de l'API: $response";
    }
}
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
        <form action="valider_commande.php" method="POST">
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
                    <input type="radio" name="livraison" value="standard" required> Standard
                </label><br>
                <label>
                    <input type="radio" name="livraison" value="relais"> Relais
                </label><br>
                <label>
                    <input type="radio" name="livraison" value="express"> Express
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