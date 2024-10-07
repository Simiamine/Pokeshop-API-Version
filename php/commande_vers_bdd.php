<?php  
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresseLivraison = $_POST['adresse'];
    $ville = $_POST['ville'];
    $paymentMethod = $_POST['payment_method'];
    $codePostal = $_POST['code_postal'];

    // Récupérer les données de la session
    $utilisateur = $_SESSION['user_id']; // ID utilisateur
    $livraison = $_POST['livraison']; // Mode de livraison sélectionné
    $total = $_SESSION['finalPrice']; // Calcul du total du panier
    $numeroCommande = uniqid(); // Génération d'un identifiant unique pour la commande

    // Construire la requête POST pour l'API de commande
    $commandeData = [
        'utilisateur' => $utilisateur,  // ID de l'utilisateur
        'adresse_livraison' => $adresseLivraison,
        'ville' => $ville,
        'code_postal' => $codePostal,
        'livraison' => $livraison,
        'total' => $total,
        'numero_commande' => $numeroCommande,
        'details' => [] // Contiendra les Pokémon commandés avec leur quantité
    ];

    // Parcourir chaque article du panier pour enregistrer les détails de la commande
    foreach ($_SESSION['panier'] as $produit) {
        $commandeData['details'][] = [
            'produit' => $produit->pokemon_id,  // ID du produit
            'quantite' => $produit->quantite    // Quantité commandée
        ];
    }

    // Convertir les données de commande en JSON
    $jsonData = json_encode($commandeData);

    // Envoyer la requête POST à l'API des commandes
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/api/commandes/"); // L'URL API des commandes
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $_SESSION['access_token']  // Token JWT
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Exécuter la requête et obtenir la réponse
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Obtenir le code HTTP de réponse

    // Vérifier si la requête a échoué
    if ($response === false) {
        echo 'Erreur lors de la requête API : ' . curl_error($ch);
        exit();
    }

    // Décoder la réponse
    $responseData = json_decode($response, true);

    // Gérer la réponse de l'API des commandes
    if ($httpcode == 201) {
        echo "Commande enregistrée avec succès !";

        // Mettre à jour le stock pour chaque produit commandé
        foreach ($_SESSION['panier'] as $produit) {
            $pokemon_id = $produit->pokemon_id;
            $quantite_commandee = $produit->quantite;

            // Construire les données pour la mise à jour du stock
            $stockData = json_encode(['quantite' => $quantite_commandee]);

            // Envoyer la requête POST à l'API pour mettre à jour le stock
            $chStock = curl_init();
            curl_setopt($chStock, CURLOPT_URL, "http://127.0.0.1:8000/api/pokedex/$pokemon_id/update-stock/"); // URL de mise à jour du stock pour chaque produit
            curl_setopt($chStock, CURLOPT_POST, 1);
            curl_setopt($chStock, CURLOPT_POSTFIELDS, $stockData);
            curl_setopt($chStock, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $_SESSION['access_token']  // Token JWT
            ]);
            curl_setopt($chStock, CURLOPT_RETURNTRANSFER, true);

            // Exécuter la requête et obtenir la réponse
            $stockResponse = curl_exec($chStock);
            $stockHttpCode = curl_getinfo($chStock, CURLINFO_HTTP_CODE);

            // Vérifier si la mise à jour du stock a échoué
            if ($stockResponse === false || $stockHttpCode != 200) {
                echo "Erreur lors de la mise à jour du stock pour le Pokémon avec ID $pokemon_id.";
            }

            curl_close($chStock);
        }

        // Vider le panier après validation de la commande et mise à jour du stock
        $_SESSION['panier'] = [];
        header("Location: ./ecran_de_validation.php"); // Redirection après succès
        exit();
    } else {
        echo "Erreur lors de l'enregistrement de la commande. Réponse API :";
        print_r($responseData);
    }

    curl_close($ch);
} else {
    // Rediriger l'utilisateur si le formulaire n'est pas soumis par POST
    header("Location: ./client/valider_commande.php"); // Modifiez avec la page de votre formulaire
    exit();
}
?>
