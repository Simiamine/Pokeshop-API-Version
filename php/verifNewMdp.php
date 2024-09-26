<?php

session_start(); 
include '../include/databaseconnect.php';

function verif(string $mdp1, string $mdp2){
    if($mdp1 === "" && $mdp2 === ""){
        $erreur = array(
            "erreur" => -3,
        );
        header('Content-Type: application/json');
        $json = json_encode($erreur);
        echo $json;
        return 0;
    }
    if ($mdp1 === "") {
        //echo '<div id="alert"> Veuillez inscrire votre nouveau mot de passe </div>';
        $erreur = array(
            "erreur" => 0,
        );
        header('Content-Type: application/json');
        $json = json_encode($erreur);
        echo $json;
        return 0;
    }
    if ($mdp2 === "") {
        //echo '<div id="alert">Veuillez vérifier votre nouveau mot de passe</div>';
        $erreur = array(
            "erreur" => -1,
        );
        header('Content-Type: application/json');
        $json = json_encode($erreur);
        echo $json;
        return 0;
    }

    if ($mdp1 !== $mdp2) {
        //echo '<div id="alert"> Les mots de passe ne correspondent pas </div>';
        $erreur = array(
            "erreur" => -2,
        );
        header('Content-Type: application/json');
        $json = json_encode($erreur);
        echo $json;
        return 0;
    }
    return 1;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Si la requête est bien reçu
    // Vérifier si toutes les données a été envoyé   
    if (isset($_POST["mdp1"], $_POST["mdp2"], $_POST["token"])){
    // Récupération de toutes les données
        $mdp1 = $_POST["mdp1"];
        $mdp2 = $_POST["mdp2"];
        $token = $_POST["token"];
        if(verif($mdp1, $mdp2)){
            if($_SESSION["idMdpPerdu"] !== -1){
                // Requete SQL
                $sql = "SELECT Utilise FROM reinitmdp WHERE Token = :token";
                $stmt = $bdd->prepare($sql);
                $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                
                $stmt->execute();
                $ligne = $stmt->fetch();
                
                if($ligne['Utilise']){  // Si le lien vient d'etre utilise
                    $erreur = array(
                        "erreur" => -4,
                    );
                    header('Content-Type: application/json');
                    $json = json_encode($erreur);
                    echo $json;
                    $bdd = null; // Fermer la connexion PDO
                }
                else{
                    $mdp_hash = password_hash($mdp1, PASSWORD_DEFAULT);  // Hashage du nouveau mdp

                    // Mettre a jour le mot de passe
                    $sql1 = "UPDATE utilisateur SET mdp = :mdp WHERE id = :id";
                    $stmt = $bdd->prepare($sql1);
                    $stmt->bindParam(':mdp', $mdp_hash, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $_SESSION["idMdpPerdu"], PDO::PARAM_INT);
                    $stmt->execute();

                    //envoieMail($mail, $preNom, 2);  // Envoie du mail pour dire que le mdp a ete modifie

                    // Mettre a jour le lien pour dire qu'il a ete utilise
                    $sql2 = "UPDATE reinitmdp SET Utilise = 1 WHERE Token = :token";
                    $stmt = $bdd->prepare($sql2);
                    $stmt->bindParam(':token', $_POST["token"], PDO::PARAM_STR);
                    $stmt->execute();
                    $bdd = null; // Fermer la connexion PDO
                    $erreur = array(
                        "erreur" => 1,
                    );
                    header('Content-Type: application/json');
                    $json = json_encode($erreur);
                    echo $json;
                }
            }
            else{
                $erreur = array(
                    "erreur" => -999,
                );
                header('Content-Type: application/json');
                $json = json_encode($erreur);
                echo $json;
            }
            $bdd = null; // Fermer la connexion PDo
        }
    }
}
?>