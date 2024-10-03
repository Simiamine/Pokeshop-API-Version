<?php 
    session_start();
    // Vérification du statut de l'utilisateur
    if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
        header('Location: ../../index.php');
        exit;
    }
?>

<?php 
    // Vérifier si l'ID du produit est présent dans l'URL
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $productId = $_GET['id'];

        // URL de l'API pour supprimer le Pokémon avec l'ID
        $url = 'http://localhost:8000/api/pokedex/' . $productId . '/';

        // Initialisation de cURL pour envoyer une requête DELETE
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Exécution de la requête
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Vérification de la réponse de l'API
        if ($httpCode == 204) {
            // Si la suppression est réussie, redirection vers la liste des produits
            header('Location: ajout_pok.php');
            exit;
        } else {
            echo "Erreur lors de la suppression du produit. Réponse de l'API : " . $response;
        }
    } else {
        // Redirection si l'ID n'est pas valide ou absent
        header('Location: ajout_pok.php');
        exit;
    }
?>
