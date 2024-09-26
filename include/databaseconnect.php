<?php 
//Connexion avec la base de données
/*
ATTENTION : CHANGER LE NOM D'UTILISATEUR ET LE MOT DE PASSE QUI SONT ICI "root"
*/
    try{
        //Valeur a modifier en fonction de la base de donnee
        $host = "localhost";
        $dbname = "pokemon";  // Nom de la base de donnee
        $username = "root";  // Identifiant pour se connecter a la base de donnee
        $password = "";  // Mot de passe de la base de donnee
        $bdd = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);  //Base de donnee SQL
    }
//erreur : renvoyer message 
    catch(PDOException $e){
        die('Erreur : '.$e->getMessage());
    }
?>
