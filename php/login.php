<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ici, vous vous assurez que la connexion est bien effectuée avec succès via l'API
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Faire l'appel API pour authentifier l'utilisateur
    $url = "http://127.0.0.1:8000/api/auth/login/";
    $data = json_encode(['email' => $email, 'password' => $password]);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($httpcode === 200) {
        $result = json_decode($response, true);
        
        // Vérifier si le token et l'ID utilisateur existent
        if (isset($result['access']) && isset($result['user_id'])) {
            // Stocker les informations nécessaires dans la session
            $_SESSION['access_token'] = $result['access'];
            $_SESSION['refresh_token'] = $result['refresh'];
            $_SESSION['user_id'] = $result['user_id'];

            // Redirection vers le profil ou une autre page
            header("Location: compte_client.php");
            exit();
        } else {
            echo "Erreur lors de la récupération des informations d'utilisateur.";
        }
    } else {
        echo "Erreur lors de la connexion. Code HTTP : " . $httpcode;
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
    <script src="../js/scriptLogin.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login2.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>
</head>

<?php session_start(); ?>
<?php include_once('../include/header.php'); ?>

<body>
    <div class="form-modal">
        <div class="form-toggle">
            <button id="login-toggle" onclick="toggleLogin()">Connexion</button>
            <button id="signup-toggle" onclick="toggleSignup()">Inscription</button>
        </div>

        <div id="login-form">
            <form>
                <input id="emailc" type="email" name="email" placeholder="Email" maxlength="50" required><br>
                <div class="champMdp">
                    <input id="mdp" type="password" name="mdp" placeholder="Mot de passe" maxlength="50" required><br>
                    <i id="boutonMdp" class="fa-regular fa-eye-slash" onclick="voirMDP()"></i>
                </div>
                <div id="rep_connexion"> </div>
                <button type="button" class="btn login" onclick="connex()">Connexion</button>
                <p><a href="javascript:toggleMdp();">Mot de passe oublié ?</a></p>
            </form>
        </div>

    <div id="signup-form">
        <form>
            <input id="prenom" type="text" name="prenom" placeholder="Prénom" maxlength="50" required/> <br>
            <input id="nom" type="text" name="nom" placeholder="Nom" maxlength="50" required/> <br>
            <input id="email" type="email" name="email" placeholder="Adresse mail" maxlength="50" required/> <br>
            <input id="tel" type="tel" name="telephone" placeholder="Numéro de téléphone" maxlength="30" required/> <br>
            <input id="dateNaiss" type="date" name="dateNaiss" placeholder="Date de naissance" required/> <br>
            <div class="champMdp">
                <input class="champMdpInput" id="mdp1" type="password" name="mdp1" placeholder="Nouveau mot de passe" maxlength="50" required/> <br> 
                <i id="boutonMdp1" class="fa-regular fa-eye-slash" onclick="voirMDP1()"></i>
            </div>
            <div class="champMdp">
                <input class="champMdpInput" id="mdp2" type="password" name="mdp2" placeholder="Confirmez le mot de passe" maxlength="50" required/> <br>
                <i id="boutonMdp2" class="fa-regular fa-eye-slash" onclick="voirMDP2()"></i>
            </div>
            <div id="rep_inscription"> </div>
            <button type="button" class="btn signup" onclick="inscript()">S'inscrire</button>
            <p>En cliquant sur le bouton, vous acceptez notre <a href="politique.php">politique de confidentialité</a>.</p>
            <hr/>
        </form>
    </div>
</div>

</body>
<?php include_once('../include/footer.php'); ?>
</html> 