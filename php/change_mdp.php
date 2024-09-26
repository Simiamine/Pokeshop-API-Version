
<?php
    session_start();
    require '../include/databaseconnect.php'; // On inclu la connexion à la bdd

    // Si la session n'existe pas 
    if(!isset($_SESSION['user_name'])){
        header('Location:../index.php');
        die();
    }

    // Si les variables existent 
    //c'est a dire si il rentre correctement le formulaire(l'ancien mot de passe et le nouveau)
    if(!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['new_password_retype'])){

// récupérer les données saisies par un utilisateur à partir d'un formulaire HTML
        $current_password = htmlspecialchars($_POST['current_password']); //Le champ 'current_password' est le champ qui demande à l'utilisateur de saisir son mot de passe actuel.
        $new_password = htmlspecialchars($_POST['new_password']);//Le champ 'new_password' est le champ qui demande à l'utilisateur de saisir son nouveau mot de passe.
        $new_password_retype = htmlspecialchars($_POST['new_password_retype']); // Le champ 'new_password_retype' est le champ qui demande à l'utilisateur de saisir à nouveau son nouveau mot de passe, pour confirmer qu'il a été correctement saisi.

        // On récupère les infos de l'utilisateur
        $check_password  = $bdd->prepare('SELECT mdp FROM utilisateur WHERE id = :id');
        $check_password->execute(array(
            "id" => $_SESSION['user_id']
        ));
        $data_password = $check_password->fetch();

        // Si le mot de passe est le bon
        if(password_verify($current_password, $data_password['mdp']))
        {
            // Si le nouveau mdp est identique au mot de passe retapé 
            if($new_password === $new_password_retype){
                // On chiffre le mot de passe
                $cost = ['cost' => 12];
                //on prends le nouveau mot de passe et le crypt c'est a dire, le mot de passe ne sera pas affiché sur la base de donnée mais sera crypté 
                $new_password = password_hash($new_password, PASSWORD_BCRYPT, $cost);
                // On met à jour la table utilisateurs avec le nouveau mot de passe 
                $update = $bdd->prepare('UPDATE utilisateur SET mdp = :mdp WHERE id = :id');
                $update->execute(array(
                    "mdp" => $new_password,
                    "id" => $_SESSION['user_id']
                ));
                // si tout se passe correctement on redirige vers la page profil 
                header('Location:client/compte_client.php');
                die();
            }
        }
        else{
            //sinon on se met sur la page profil en affichant une erreur 
            header('Location:../index.php');
            die();
            
        }

    }
    else{
        echo ("shiiiiiiiiiiiit");
    }
?>
