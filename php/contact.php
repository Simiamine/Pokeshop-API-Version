<?php 
   session_start();
   include 'envoiMail.php';  // Include la fonction pour envoyer le mail contact
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokeshop</title>
    <script src="https://kit.fontawesome.com/d6a49ddf6e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/contact.css">
    <link rel="icon" type="image/png" href="../img/icon.png"/>



</head>
<body>
<?php include_once('../include/header.php'); ?>
    <script>
        $("#contact").addClass("active");  // Fonction pour mettre la class "active" en fonction de la page
    </script>


<section id="contact-form">
    <div class="container">
        <div class="formulaire">
        <form action="contact.php" method="post">
            <div id="titreContact">Contact</div><br>
            <div id="infoComp">Veuillez remplir le formulaire ci dessous<br> Ou contactez-nous au <a style="color : #cc0000;" href tel=0123456789>+33 1 23 45 67 89</a><br></div>
            <label for="name">Nom :</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="email">Email :</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="message">Message :</label><br>
            <textarea id="message" name="message" rows="4" required></textarea><br>
            <input type="submit" value="Envoyer">
        </form>
        </div>
    </div>
</section>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
            echo "Veuillez remplir les champs.";
            exit;
        }

        if (mailContact($name, $email, $message)) {
            echo "<div class='alert-vert'>Votre message a été envoyé avec succès !</div>";
        } else {
            echo "<div class='alert-orange'>Hmmm... Il y a une erreur...</div>";
        }
    }
?>
</section>
</body>
<?php include_once('../include/footer.php'); ?>
</html>

