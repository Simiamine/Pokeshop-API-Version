<?php
session_start(); // Démarrage de la session
$temps_attente = 8;
$temps_attenteMailMdp = 10;

include '../include/databaseconnect.php'; // Assurez-vous que ce chemin d'accès est correct
include 'envoiMail.php';  // Include la fonction pour envoyer le mail Token

function test(string $prenom, string $nom, string $email, string $tel, string $dateNaiss, string $mdp1, string $mdp2 , array $erreur){
    // Fonction qui vérifie toute les données en fonction de chaques conditions
    
    if (!preg_match("/^[a-zA-Z-' ]*$/",$prenom)) {  // Vérifie que le prénom est bien composé de lettre seulement
        $erreur["prenom"] = -1; // Mauvais 
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/",$nom)) {
        $erreur["nom"] = -1;
    }
    // Vérifie que chaque valeur ne sont pas vide
    if ($prenom === "") {
        $erreur["prenom"] = 0;
    }
  
    if ($nom === "") {
        $erreur["nom"] = 0;
    }

    if(!preg_match('/^\d+$/', $tel)) {
        $erreur["telephone"] = -1;
    }
    if($tel === ""){
        $erreur["telephone"] = 0;
    }
    

    // DATE VERIFICATION
    // Créer un objet DateTime à partir de la chaîne en spécifiant le format
    $dateObj = DateTime::createFromFormat('d/m/Y', $dateNaiss);
    // Vérifier si l'objet DateTime a été créé avec succès
    if ($dateObj !== false && $dateObj->format('d/m/Y') === $dateNaiss) {
        $erreur["dateNaissance"] = 1;
    } else {
        $erreur["dateNaissance"] = -1;
    }

    if($dateNaiss === ""){  // Vérifier qu'une date à bien été mise
        $erreur["dateNaissance"] = 0;
    }
    // Mail 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  // Vérifie que l'email est au bon format
        $erreur["email"] = -1;
    }
    if($email === ""){
        $erreur["email"] = 0;
    }
    // Sécurité du mot de passe 
    if (!preg_match("/\d/", $mdp1)) {
        $erreur["mdp"] = -6;  // Le mot de passe doit contenir un chiffre
    }
    if (!preg_match("/[A-Z]/", $mdp1)) {
        $erreur["mdp"] = -7;  // Le mot de passe doit contenir une majuscule
    }
    if (!preg_match("/[a-z]/", $mdp1)) {
        $erreur["mdp"] = -8;  // Le mot de passe doit contenir une minuscule
    }
    if (!preg_match("/\W/", $mdp1)) {
        $erreur["mdp"] = -9;  // Le mot de passe doit contenir un caractere speciale
    } 
    if(strlen($mdp1) <= 7){
        $erreur["mdp"] = -5;  // Le mot de passe fait moins de 7 caractères
    }
    if ($mdp1 !== $mdp2) {  // Les mdp ne correspondent pas
        $erreur["mdp"] = -3;  // les mdp sont differents
    }
    if($mdp1 === ""){
        $erreur["mdp"] = -4;
    }
    if($mdp2 === ""){
        $erreur["mdp"] = -2;  // il faut que l'utilisateur verifie son mdp
    }
    if ($mdp1 === "" && $mdp2 === "") {
        $erreur["mdp"] = 0;  // il faut que l'utilisateur mette les mots de passe
    }
    return $erreur;
}
function testco(string $email, string $mdp, array $erreur){
    // Fonction qui vérifie toute les données en fonction de chaques conditions
  
    // Vérifie que chaque valeur ne sont pas vide
    if($email == ""){
        $erreur["email"] = 0;
    }
    if($mdp == ""){
        $erreur["mdp"] = 0;
    }
    return $erreur;
}


//Verifier l'unicite d'un mail
function mailUnique(PDO $pdo, string $mail){
    $sql = "SELECT COUNT(*) FROM utilisateur WHERE email = :Mail";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':Mail', $mail, PDO::PARAM_STR);
    $stmt->execute();
          
    $compteur = $stmt->fetchColumn();  // (>0 : l'email existe déjà, =0 : l'email n'existe pas)
    if($compteur > 0){
        return 0;
    }
    return 1;
}

//Verifier qu'il n'y a aucune erreur dans la liste d'erreur
function checkErreur(array $erreur){
    foreach($erreur as $val){
        if($val != 1){
            return 0;
        }
    }
    return 1;
}

function verifierIdentifiant(PDO $pdo, string $mail, string $mdp){
    // Requête SQL pour rechercher l'utilisateur par email dans la table admin
    $sql = "SELECT * FROM utilisateur WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $mail, PDO::PARAM_STR);
    $stmt->execute();
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Verification du mdp pour admin
    if ($utilisateur && password_verify($mdp, $utilisateur['mdp'])) {
        // Connexion réussie
        $_SESSION['user_id'] = $utilisateur['id'];
        $_SESSION['user_name'] = $utilisateur['prenom']; 
        $_SESSION['user_statut'] = $utilisateur['statut']; // Stockez le statut de l'utilisateur dans la session
        $pdo = null; // Fermer la connexion PDO
        // CONTINUER LA
        return 1;
    } else {
        $pdo = null; // Fermer la connexion PDO
        return 0;
    }
}

// Fonction pour vérifier si une autre demande à été fait il y a moins de 10 min
function reinitExiste(PDO $pdo, int $idUser){
    // Requete SQL pour selectionner les demandes de reinitialisation deja existante
    $sql = "SELECT DateExp FROM reinitmdp WHERE Utilisateur = :iduser AND Utilise = 0"; 
    $stmt = $pdo->prepare($sql);

    // Binder les valeurs aux paramètres de la requête
    $stmt->bindParam(':iduser', $idUser, PDO::PARAM_INT);

    // Executer la requête
    $stmt->execute();

    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Récupération des résultats
        
    /////// Comparaison des demandes //////////////

    $format = mktime(
        date("H"), date("i")+50, date("s"), date("m") ,date("d"), date("Y")
       ); //+50 min pour que puisse demander une requete de reinitialisation toute les 10 min
    $dateLim = date("Y-m-d H:i:s", $format);  // Date et heure actuelle
    if($demandes){
        foreach($demandes as $demande){
            if($dateLim < $demande['DateExp']){  // Si l'utilisateur a demande une requete il y a moins de min
                return 0;
            }
        }
    }
    return 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Si la requête est bien reçu
    // Vérifier si toutes les données ont été envoyées   
    // MDP PERDU
    if(isset($_POST["emailMdp"])){
        // Mettre un temps d'attente pour éviter les attaques par force brute
        if(isset($_SESSION['tempsMailMdp'])) {
            $tempsEcoule = time() - $_SESSION['tempsMailMdp'];
            if ($tempsEcoule < $temps_attenteMailMdp) {
                $tempsRestant = $temps_attenteMailMdp - $tempsEcoule;
                // Liste des erreurs sur les valeurs rentrées par l'utilisateur
                $erreur = array(
                    'temps' => $tempsRestant,
                );
                header('Content-Type: application/json');
                $json = json_encode($erreur);
                echo $json;
                exit;
            } 
        }
        if($_POST["emailMdp"] == ""){
            // Envoie de la réponse
            header('Content-Type: application/json');
            $erreur = array(
                'erreur' => 0,
            );
            $json = json_encode($erreur);
            echo $json;
            exit;
        }
        $valErreur = -10;
        $email = strtolower($_POST["emailMdp"]);
        // Requête SQL :
        $sql = "SELECT id FROM utilisateur WHERE email = :email";
        // Préparer la requête
        $stmt = $bdd->prepare($sql);

        // Binder les valeurs aux paramètres de la requête
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // Exécuter la requête
        $stmt->execute();
        // Récupérer les résultats
        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = 0;
        if($ligne){
            $user = $ligne["id"];
            if(reinitExiste($bdd, $user)){
                $format = mktime(
                    date("H")+1, date("i"), date("s"), date("m") ,date("d"), date("Y")
                ); //+1 h pour que l'utilisateur ait du temps pour changer le mdp 
                $date = date("Y-m-d H:i:s",$format);
                $token = bin2hex(random_bytes(30));
                // Insertion des données dans la table avec statut par défaut
                $sql2 = "INSERT INTO reinitmdp (Utilisateur, DateExp, Token) VALUES (:utilisateur, :dateexp, :token)";
                $stmt2 = $bdd->prepare($sql2);
                // Binder les valeurs aux paramètres de la requête
                $stmt2->bindParam(':utilisateur', $user, PDO::PARAM_INT);
                $stmt2->bindParam(':dateexp', $date, PDO::PARAM_STR);
                $stmt2->bindParam(':token', $token, PDO::PARAM_STR);
                // // Exécuter la requête
                $stmt2->execute();
                mailToken($email, $token);
            }else{
                $valErreur = -11;
            }
        }
        // Envoie de la réponse
        header('Content-Type: application/json');
        $erreur = array(
            'erreur' => $valErreur,
            'User' => $user,
        );
        $json = json_encode($erreur);
        $_SESSION['tempsMailMdp'] = time();
        echo $json;
        $bdd = null; // Ferme la connexion PDO
    }

    // INSCRIPTION
    else if (isset($_POST["prenom"], $_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["dateNaiss"], $_POST["mdp1"], $_POST["mdp2"])){
        // Récupération de toutes les données
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $mail = $_POST["email"];
        $tel = $_POST["tel"];
        $dateNaiss = $_POST["dateNaiss"];
        $mdp1 = $_POST["mdp1"];
        $mdp2 = $_POST["mdp2"]; 
    
        // Liste des erreurs sur les valeurs rentrées par l'utilisateur
        $erreur = array(
            'prenom' => 1,
            'nom' => 1,
            'email' => 1,
            'telephone' => 1,
            'dateNaissance' => 1,
            'mdp' => 1,
        );
        $erreur = test($prenom, $nom, $mail, $tel, $dateNaiss, $mdp1, $mdp2, $erreur);
        
        // Vérifier si le mail est unique et s'il n'y a aucune erreur
        if(checkErreur($erreur)){
            if(!mailUnique($bdd, $mail)){
                $erreur["email"] = -10;
            }
            else{
                // Transformation du prénom et du nom au bon format
                $prenom = ucfirst(strtolower($prenom));
                $mail = strtolower($mail);
                $nom = strtoupper($nom);
        
                // Insertion des données dans la table avec statut par défaut
                $sql = "INSERT INTO utilisateur (prenom, nom, email, telephone, dateNaissance, mdp, statut) VALUES (:prenom, :nom, :mail, :telephone, :dateNaissance, :mdp, 'client')";
        
                // Préparer la requête
                $stmt = $bdd->prepare($sql);
                
                $mdp1 = password_hash($mdp1, PASSWORD_DEFAULT);  // Cryptage du mdp
        
                // Binder les valeurs aux paramètres de la requête
                $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
                $stmt->bindParam(':telephone', $tel, PDO::PARAM_STR);
                $stmt->bindParam(':dateNaissance', $dateNaiss, PDO::PARAM_STR);
                $stmt->bindParam(':mdp', $mdp1, PDO::PARAM_STR);
        
                // Exécuter la requête
                $stmt->execute();
            }
        }
        header('Content-Type: application/json');
        $json = json_encode($erreur);
        echo $json;
        $bdd = null; // Fermer la connexion PDO
    }
    
    // CONNEXION
    else if (isset($_POST["emailc"], $_POST["mdp"])){
        // Mettre un temps d'attente pour éviter les attaques par force brute
        if (isset($_SESSION['temps'])) {
            $tempsEcoule = time() - $_SESSION['temps'];
            if ($tempsEcoule < $temps_attente) {
                $tempsRestant = $temps_attente - $tempsEcoule;
                // Liste des erreurs sur les valeurs rentrées par l'utilisateur
                $temps = array(
                    'temps' => $tempsRestant,
                );
        
                header('Content-Type: application/json');
                $json = json_encode($temps);
                echo $json;
                exit;
            } 
        }
        $email = $_POST["emailc"];
        $mdp = $_POST["mdp"];
        // Liste des erreurs sur les valeurs rentrées par l'utilisateur
        $erreur = array(
            'email' => 1,
            'mdp' => 1,
        );  

        $erreur = testco($email, $mdp, $erreur);
        if(checkErreur($erreur)){
            $email = strtolower($email);
            if(verifierIdentifiant($bdd, $email, $mdp)){
                $erreur = array(
                    'connecte' => 1, 
                );  
            }
            else{
                $erreur = array(
                     'temps' => "non",  // On va faire patienter la personne quelque seconde avant un nouvel essaie (Le dissuader de craquer un mot de passe de manière force)
                );  
                $_SESSION['temps'] = time();
        }
        }  
        header('Content-Type: application/json');
        $json = json_encode($erreur);
        echo $json;
        $bdd = null; // Fermer la connexion PDO
        
    }
}



?>