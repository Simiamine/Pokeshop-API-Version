<?php
/*
    Fonction php et html pour recuperer un mot de passe qui a ete perdu par l'utilisateur.
*/

//include la fonction databaseconnect.php 
include '../include/databaseconnect.php';

if(isset($_GET['token'])){
    $token = $_GET['token'];  // Recuperation du token se trouvant dans le lien
}
else{
    header("Location: ../index.php"); // Rediriger vers la page de connexion si l'utilisateur n'a pas de token
    exit;
}
session_start(); 
$existeToken = 0;  // Valeur pour savoir si le token existe dans la base de donnee
$expireDate = 0;  // Valeur pour savoir si la date du token est expire
$dejaUtilise = 0;
$dateActu = date("Y-m-d H:i:s");  // Date et heure actuelle
// Preparation de la commande SQL
$sql = "SELECT * FROM reinitmdp WHERE Token = :token";  // Requete SQL
$stmt = $bdd->prepare($sql);
$stmt -> bindParam(':token', $token);
$stmt -> execute();
$ligne = $stmt->fetch(PDO::FETCH_ASSOC);
if($ligne){  // S'il existe une ligne avec le token
    $existeToken = 1;
    if($dateActu < $ligne['DateExp']){
        $dejaUtilise = $ligne['Utilise'];
        $expireDate = 1;  // La date n'est pas expire
        $_SESSION["idMdpPerdu"] = $ligne['Utilisateur'];
    }
}
$bdd = null; // Fermer la connexion PDO
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe | Pokeshop</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="../js/scriptLogin.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
</head>



<body>
<div class="form-modal">
    <div id="newMdp-form">
        <form>
            <?php
            if($existeToken == 0){
                echo '<div id="rep_newMdp" class="alert-rouge"> Le lien est invalide </div>  ';
            }
            else if($expireDate == 0){
                echo '<div id="rep_newMdp" class="alert-orange"> Le lien a expiré </div>  ';
            }
            else if($dejaUtilise == 1){
                echo '<div id="rep_newMdp" class="alert-orange"> Le lien a déjà été utilisé </div>  ';
            }
            else{
                echo"
            <div class='titre'>
                Création d'un nouveau mot de passe
            </div>
            <div class='champMdp'>
                <input class='champMdpInput' id='mdp1' type='password' name ='mdp1' placeholder='Nouveau mot de passe' maxlength='50' required/> <br> 
                <!--<input class='champMdpBouton' type='checkbox' onclick='voirMDP1()'> <br> bouton pour montrer le mdp -->
                <i id='boutonMdp1' class='fa-regular fa-eye-slash' onclick='voirMDP1()'></i>
            </div>
            <div class='champMdp'>
                <input class='champMdpInput' id='mdp2' type='password' name ='mdp2' placeholder='Confirmez le nouveau mot de passe' maxlength='50' required/> <br>
                <i id='boutonMdp2' class='fa-regular fa-eye-slash' onclick='voirMDP2()'></i>
            </div>
            <div id='rep_newMdp'> </div>
            <button type='button' class='btn btn_mdp' onclick='changeNewMdp()'>Changer le mot de passe</button>
            <hr/>";
            }
            ?>
        </form>
    </div>
</div>
</body>

</html>