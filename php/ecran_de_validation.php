<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Commande</title>
    <link rel="stylesheet" href="styles.css">
</head>


<style>
    body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
}

body {
    background-image: url('../img/desktop-wallpaper-ultra-water-pokemon-and-background-pokemon-underwater.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: Arial, sans-serif;
}

.confirmation-container {
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

button {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 20px 2px;
    cursor: pointer;
    border-radius: 5px;
}
</style>
<body>
    <div class="confirmation-container">
        <h1>Merci pour votre commande !</h1>
        <p>Votre commande a été placée avec succès et sera traitée sous peu.</p>
        <p>Un e-mail de confirmation a été envoyé à votre adresse. Si vous avez des questions, n'hésitez pas à nous contacter.</p>
        <button onclick="window.location.href='../index.php'">Retour à la page d'accueil</button>
    </div>
</body>
</html>
