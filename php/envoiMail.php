<?php
/* Fichier pour envoyer des mails avec php mailer
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";

// Fonction d'envoi du mail pour la page mot de passe perdu
function mailToken(string $adrMail, string $token){ 
    try{
        $path = basename(dirname(dirname(__FILE__)));  // Permet d'obtenir le nom du dossier ou sont stocké tout les fichiers

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPDebug = 0;  //desactive les debug SMTP
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pokeshop.nepasrepondre@gmail.com';
        $mail->Password = 'xsgeirifpulzeudq';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('pokeshop.nepasrepondre@gmail.com', "Pokeshop - Support");

        $mail->addAddress($adrMail);

        $mail->isHTML(true);

        $mail->Subject = "Lien pour créer un mot de passe";

        $mail->Body = "
Bonjour dresseur !<br><br>

Voici un lien pour te créer un nouveau mot de passe : <a href="."http://localhost:3000/".$path."/php/nouveau_mdp.php?token=".$token.">"."http://localhost:3000/".$path."/php/nouveau_mdp.php?token=".$token."</a>
<br><br>
Tâche de ne pas perdre ton nouveau mot de passe !<br>
À bientôt !
";

        // Paramètres pour gérer les caractères spéciaux
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->send();

        return 1;
    }
    catch (Exception $e) {
        return 0;
    }
}

// Fonction d'envoi du mail pour la page contact
function mailContact(string $nom, string $adrMail, string $msg){ 
    try{
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPDebug = 0;  //desactive les debug SMTP
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pokeshop.nepasrepondre@gmail.com';
        $mail->Password = 'xsgeirifpulzeudq';  // Mot de passe d'application pour le mail google
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('pokeshop.nepasrepondre@gmail.com', "Pokeshop - Contact");

        $mail->addAddress("chanthrabo@cy-tech.fr");  // MAIL A MODIFIER SELON LE RECEVEUR !!!

        $mail->isHTML(true);

        $mail->Subject = "Demande de : ".$nom;

        $mail->Body = "
Bonjour, voici une demande d'un utilisateur de la page contact :<br><br>
Nom : ".$nom."<br>
Mail : ".$adrMail."<br>
Message : ".$msg."<br><br>

Au revoir.
";
        // Paramètres pour gérer les caractères spéciaux
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->send();

        return 1;
    }
    catch (Exception $e) {
        return 0;
    }

}

?>