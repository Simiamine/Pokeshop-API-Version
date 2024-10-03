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
    $utilisateur = $_SESSION['user_id']; // Modifié de 'utilisateur_id' à 'utilisateur'
    $livraison = $_POST['livraison']; // Mode de livraison sélectionné
    $total = $_SESSION['finalPrice']; // Calcul du total du panier
    $numeroCommande = uniqid(); // Génération d'un identifiant unique pour la commande

    // Construire la requête POST pour l'API
    $commandeData = [
        'utilisateur' => $utilisateur,  // Modifié ici pour correspondre à ce que l'API attend
        'adresse_livraison' => $adresseLivraison,
        'ville' => $ville,
        'code_postal' => $codePostal,
        'livraison' => $livraison,
        'total' => $total,
        'numero_commande' => $numeroCommande,
        'produits' => []
    ];

    // Parcourir chaque article du panier pour enregistrer les détails
    foreach ($_SESSION['panier'] as $produit) {
        $commandeData['produits'][] = [
            'pokemon_id' => $produit->pokemon_id,
            'quantite' => $produit->quantite
        ];
    }

    // Convertir les données en JSON
    $jsonData = json_encode($commandeData);

    // Envoyer la requête POST à l'API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/api/commandes/"); // L'URL API doit finir par un /
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
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

    // Gérer les erreurs de l'API
    if ($httpcode == 201) {
        echo "Commande enregistrée avec succès !";
        // Vider le panier après validation de la commande
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
