<?php  
    session_start();
    if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
        header('Location: ../../index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des commandes</title>
    <script src="../js/pokemon.js" defer></script>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/style2.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="icon" type="image/png" href="../../img/icon.png"/>
</head>

<?php include_once('../../include/header.php'); ?>
<script>
    $("#pokemon").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
</script>

<div class="mt-3 container-fluid pb-3 flex-grow-1 d-flex flex-column flex-sm-row overflow-auto">
    <div class="row flex-grow-sm-1 flex-grow-0 container-fluid">
        <main class="col overflow-auto h-100 w-100">
            <div class="container py-2">
                <h2>Liste des commandes</h2>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Client</th>
                            <th>Numéro commande</th>
                            <th>Ville</th>
                            <th>Code postal</th>
                            <th>Livraison</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // URL de l'API pour les commandes
                        $api_url = 'http://127.0.0.1:8000/api/commandes/';

                        // Initialiser cURL pour récupérer les commandes
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $api_url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        // Exécuter la requête GET pour les commandes
                        $response = curl_exec($ch);

                        if (curl_errno($ch)) {
                            echo 'Erreur cURL : ' . curl_error($ch);
                        } else {
                            $commandes = json_decode($response, true);

                            foreach ($commandes as $commande) {
                                // Vérification que le champ utilisateur_id est bien présent
                                if (isset($commande['utilisateur_id']) && !empty($commande['utilisateur_id'])) {
                                    $utilisateur_id = $commande['utilisateur_id'];
                                    $utilisateur_url = 'http://127.0.0.1:8000/api/utilisateurs/' . $utilisateur_id . '/';

                                    // Initialiser une nouvelle requête cURL pour l'utilisateur
                                    $user_ch = curl_init();
                                    curl_setopt($user_ch, CURLOPT_URL, $utilisateur_url);
                                    curl_setopt($user_ch, CURLOPT_RETURNTRANSFER, true);

                                    // Exécuter la requête GET pour récupérer les détails de l'utilisateur
                                    $user_response = curl_exec($user_ch);
                                    $user = json_decode($user_response, true);

                                    // Fermer cURL pour l'utilisateur
                                    curl_close($user_ch);

                                    // S'assurer que les informations de l'utilisateur sont valides avant de les afficher
                                    $prenom = isset($user['prenom']) ? htmlspecialchars($user['prenom']) : 'Inconnu';
                                    $nom = isset($user['nom']) ? htmlspecialchars($user['nom']) : 'Inconnu';
                                } else {
                                    $prenom = 'Inconnu';
                                    $nom = 'Inconnu';
                                }

                                // Vérifier si 'date_creation' existe dans la commande
                                $date_creation = isset($commande['date_creation']) ? htmlspecialchars($commande['date_creation']) : 'Date inconnue';

                                // Afficher les informations de la commande et de l'utilisateur
                                echo "<tr onclick=\"window.location.href='detail_commande.php?id_commande=" . $commande['id'] . "'\" style='cursor:pointer'>";
                                echo "<td>" . htmlspecialchars($commande['id']) . "</td>";
                                echo "<td>" . $prenom . ' ' . $nom . "</td>"; // Remplace l'ID par le nom et prénom de l'utilisateur
                                echo "<td>" . htmlspecialchars($commande['numero_commande']) . "</td>";
                                echo "<td>" . htmlspecialchars($commande['ville']) . "</td>";
                                echo "<td>" . htmlspecialchars($commande['code_postal']) . "</td>";
                                echo "<td>" . htmlspecialchars($commande['livraison']) . "</td>";
                                echo "<td>" . htmlspecialchars($commande['total']) . "€</td>";
                                echo "<td>" . $date_creation . "</td>";
                                echo "</tr>";
                            }
                        }

                        // Fermer cURL pour les commandes
                        curl_close($ch);
                    ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
</body>
</html>
