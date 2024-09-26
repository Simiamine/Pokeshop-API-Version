<?php 
    session_start();
    require  '../../include/databaseconnect.php';
    if (!isset($_SESSION['user_statut']) || $_SESSION['user_statut'] != "admin") {
        header('Location: ../../index.php');
        exit;
    }  
?>
<?php 
    // Vérifier si l'ID du produit est présent
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $productId = $_GET['id'];

    // Préparez la requête de suppression
    $query = $bdd->prepare("DELETE FROM Pokedex WHERE id = :id");
    $query->bindParam(':id', $productId, PDO::PARAM_INT);
    
    if($query->execute()){
        // Redirection vers la liste des produits après suppression
        header('Location: ajout_pok.php');
        exit;
    } else {
        echo "Erreur lors de la suppression du produit.";
    }
} else {
    // Redirection si l'ID n'est pas valide ou présent
    header('Location: ajout_pok.php');
    exit;
}

?>