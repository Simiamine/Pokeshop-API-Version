<?php
session_start();

// Gestion de l'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'inscription') {
    // Récupération des données du formulaire d'inscription
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $date_naissance = $_POST['dateNaiss'];
    $password = $_POST['mdp1'];
    $password2 = $_POST['mdp2'];

    // Vérification que les deux mots de passe sont identiques
    if ($password !== $password2) {
        echo "<script>alert('Les mots de passe ne correspondent pas.');</script>";
        exit();
    }

    // Création des données à envoyer à l'API d'inscription
    $data = [
        'prenom' => $prenom,
        'nom' => $nom,
        'email' => $email,
        'telephone' => $telephone,
        'date_naissance' => $date_naissance,
        'password' => $password,
        'password2' => $password2
    ];

    // Appel à l'API d'inscription
    $url = "http://127.0.0.1:8000/api/inscription/";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    // Vérification de la réponse API
    if ($httpcode === 201) {
        // Affichage d'une popup pour informer l'utilisateur
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('inscriptionSuccessPopup').style.display = 'block';
                    document.getElementById('overlay').style.display = 'block';
                });
              </script>";
    } else {
        echo "<script>alert('Erreur lors de l\\'inscription.');</script>";
    }

    curl_close($curl);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'identifier | Pokeshop</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../js/scriptLogin.js"></script> <!-- Ajout de votre fichier JS pour la gestion de la connexion -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login2.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
</head>

<?php include_once('../include/header.php'); ?>

<body>
    <div class="form-modal">
        <div class="form-toggle">
            <button id="login-toggle" onclick="toggleLogin()">Connexion</button>
            <button id="signup-toggle" onclick="toggleSignup()">Inscription</button>
        </div>

        <div id="login-form">
            <form method="POST" onsubmit="event.preventDefault(); connex();"> <!-- Liaison avec la fonction 'connex()' -->
                <input id="emailc" type="email" name="email" placeholder="Email" maxlength="50" required><br>
                <div class="champMdp">
                    <input id="mdp" type="password" name="password" placeholder="Mot de passe" maxlength="50" required><br>
                    <i id="boutonMdp" class="fa-regular fa-eye-slash" onclick="voirMDP()"></i>
                </div>
                <button type="submit" class="btn login">Connexion</button>
                <p><a href="javascript:toggleMdp();">Mot de passe oublié ?</a></p>
            </form>
        </div>

        <!-- Formulaire d'inscription -->
        <div id="signup-form">
            <form method="POST">
                <input type="hidden" name="action" value="inscription"> <!-- Action pour différencier l'inscription -->
                <input id="prenom" type="text" name="prenom" placeholder="Prénom" maxlength="50" required/><br>
                <input id="nom" type="text" name="nom" placeholder="Nom" maxlength="50" required/><br>
                <input id="email" type="email" name="email" placeholder="Adresse mail" maxlength="50" required/><br>
                <input id="tel" type="tel" name="telephone" placeholder="Numéro de téléphone" maxlength="30" required/><br>
                <input id="dateNaiss" type="date" name="dateNaiss" placeholder="Date de naissance" required/><br>
                <div class="champMdp">
                    <input class="champMdpInput" id="mdp1" type="password" name="mdp1" placeholder="Nouveau mot de passe" maxlength="50" required/><br> 
                    <i id="boutonMdp1" class="fa-regular fa-eye-slash" onclick="voirMDP1()"></i>
                </div>
                <div class="champMdp">
                    <input class="champMdpInput" id="mdp2" type="password" name="mdp2" placeholder="Confirmez le mot de passe" maxlength="50" required/><br>
                    <i id="boutonMdp2" class="fa-regular fa-eye-slash" onclick="voirMDP2()"></i>
                </div>
                <button type="submit" class="btn signup">S'inscrire</button>
                <p>En cliquant sur le bouton, vous acceptez notre <a href="politique.php">politique de confidentialité</a>.</p>
                <hr/>
            </form>
        </div>
    </div>

    <!-- Overlay pour l'effet de fond flouté -->
    <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 1000;"></div>

    <!-- Popup d'inscription réussie -->
    <div id="inscriptionSuccessPopup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5); z-index: 1001;">
        <h3>Inscription réussie !</h3>
        <p>Votre inscription a bien été prise en compte.</p>
        <p>Veuillez maintenant vous connecter.</p>
        <button class="btn btn-success" id="closeInscriptionPopup">OK</button>
    </div>

    <script>
        // Fermer la popup d'inscription réussie et revenir sur la page de connexion
        document.getElementById('closeInscriptionPopup').addEventListener('click', function() {
            document.getElementById('inscriptionSuccessPopup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
            toggleLogin();  // Activer la page de connexion
        });
    </script>

</body>

<?php include_once('../include/footer.php'); ?>

</html>
