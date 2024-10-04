<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <!-----FIN DU MENU ----->
  <table class="table table-striped table-hover">
                <div class="bg-light border rounded-3 p-3">
                    <a name="0">
                        <div class="d-flex justify-content-center">
                            <h2>Livraison du Pokemon</h2>
                        </div>
                        <div class="d-flex justify-content-center">
                            <h3>Temps de préparation : 1-3 jours</h3>
                        </div>
                        <br>
                        <!---- Cette partie concerne le mode de livraison, il explique toutes les conditions ---->
                        <table>
                            <tr colspan="3" style="background-color: #D3D3D3;">
                                <th>Mode de livraison</th>
                                <th>Temps de livraison</th>
                                <th>Frais</th>
                            </tr>
                            <tr>
                                <td>Livraison Standard</td>
                                <td>5 jours ouvrables</td>
                                <td>5.00€—Pour chaque livraison<br> Reduction avec l'accumulation des points.</td>
                            </tr>
                            <tr>
                                <td>Livraison en Point Relais</td>
                                <td>5-6 jours ouvrables</td>
                                <td>2.00€—Pour chaque livraison<br> Reduction avec l'accumulation des points.</td>
                            </tr>
                            <tr>
                                <td>Livraison Express</td>
                                <td>1-2 jours ouvrables</td>
                                <td>8.00€</td>
                            </tr>
                        </table>
                        <p>Les frais de livraison sont susceptibles d'être modifiés sans préavis. Veuillez vous référer
                            à la page de paiement pour obtenir les frais de livraison actuels.</td>
                            </tr><br>
                            <p>Si vous constatez que :</p>
                            <ol>
                                <li>Votre Pokemon n'a pas été livré dans les délais prévus</li>
                                <li>Les informations de suivi indiquent que le colis a été livré mais que vous ne l'avez
                                    pas reçu</li>
                                <li>Votre colis contient des Pokemons manquants/blessés/violent</li>
                            </ol>
                            <p>Veuillez contacter le service clientèle dans les 45 jours suivant la date de paiement
                                afin que les problèmes susmentionnés puissent être résolus. Pour les autres commandes,
                                les pokemons et les problèmes liés à la logistique, veillez à contacter le service
                                clientèle dans les 90 jours suivant la date de la commande, cela n'affecte pas vos
                                droits statutaires.</p>
                            <p>Nous vous informons que la livraison en point relais Mondial Relay est rétablie dès
                                maintenant. Cependant, certains centres restent fermées ou rajustent leurs heures
                                d’ouverture. Veuillez vérifier au préalable sur le site du Mondial Relay si votre point
                                relais habituel est ouvert.</p>
                            <p>Veuillez cliquer sur le bouton "Confirmer la livraison" dans les 6 mois à compter de la
                                date d'expédition. Après cela, le bouton deviendra gris et ne pourra plus être utilisé
                                pour obtenir des points supplémentaires.</p>
                            <p>Dans la plupart des cas, le colis sera livré dans les délais estimés. Cependant, la date
                                réelle de livraison peut être changée par les vols, les conditions météorologiques ou
                                d'autres facteurs externes. Veuillez-vous référer aux informations de suivi pour une
                                date de livraison plus précise.</p>
                    </a>
</table>
                   
                    <!---- Cette partie concerne les politiques de confidentialité, il explique toutes les conditions ---->
                    
                    <div class="bg-light border rounded-3 p-3">
                        <a name="2">
                            <div class="d-flex justify-content-center">
                                <h2>Politique de confidentialité</h2>
                            </div>
                            </br>
                            <p>Nous accordons une grande importance à la protection de vos données personnelles et à
                                la confidentialité de vos informations. Cette politique de confidentialité explique
                                comment <strong><em>nous recueillons, utilisons et partageons vos données
                                        personnelles</strong></em>lorsque vous utilisez notre site e-commerce.</p>
                            <strong>Collecte de données personnelles</strong>
                            <p>Nous recueillons les données personnelles que vous nous fournissez lorsque vous créez
                                un compte sur notre site e-commerce, lorsque vous passez une commande, lorsque vous
                                contactez notre service clientèle ou lorsque vous vous inscrivez à notre newsletter.
                                Ces données peuvent inclure votre nom, votre adresse e-mail, votre adresse de
                                livraison, votre numéro de téléphone, vos informations de paiement et d'autres
                                informations que vous choisissez de nous fournir.</p>
                            <strong>Utilisation des données personnelles</strong>
                            <p>Nous utilisons vos données personnelles pour traiter vos commandes, pour communiquer
                                avec vous au sujet de vos commandes, pour personnaliser votre expérience d'achat sur
                                notre site e-commerce et pour vous envoyer des offres promotionnelles ou des
                                informations sur nos produits et services. Nous pouvons également utiliser vos
                                données personnelles pour améliorer notre site e-commerce, pour prévenir la fraude
                                et pour assurer la sécurité de nos utilisateurs.</p>
                            <strong>Partage des données personnelles</strong>
                            <p>Nous ne partageons pas vos données personnelles avec des tiers, sauf si cela est
                                nécessaire pour traiter vos commandes ou si nous sommes légalement tenus de le
                                faire. Nous pouvons partager vos données personnelles avec nos fournisseurs de
                                services tiers qui nous aident à traiter les paiements, à expédier les commandes et
                                à fournir des services de support clientèle.</p>
                            <strong>Sécurité des données personnelles</strong>
                            <p>Nous prenons des mesures de sécurité raisonnables pour protéger vos données
                                personnelles contre les accès non autorisés, les pertes ou les modifications.
                                Toutefois, nous ne pouvons garantir la sécurité absolue de vos données personnelles.
                            </p>
                            <strong>Droit d'accès, de rectification et de suppression des données
                                personnelles</strong>
                            <p>Vous avez le droit d'accéder à vos données personnelles que nous avons enregistrées,
                                de les corriger si elles sont inexactes ou de demander leur suppression. Si vous
                                avez des questions ou des préoccupations concernant notre politique de
                                confidentialité ou la gestion de vos données personnelles, veuillez nous contacter à
                                l'adresse e-mail fournie sur notre site e-commerce.</p>

                            <em>Nous pouvons mettre à jour cette politique de confidentialité de temps à autre. Nous
                                vous informerons de toute modification importante de cette politique de
                                confidentialité par e-mail ou par une notification sur notre site e-commerce.</em>

                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
