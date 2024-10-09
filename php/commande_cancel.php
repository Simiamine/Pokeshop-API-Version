<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Échec du paiement</title>
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
    background-image: url('../img/wallpapergengar.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: Arial, sans-serif;
}

.echec-container {
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

button {
    background-color: #FF4500;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    display: inline-block;
    font-size: 16px;
    margin: 20px 2px;
    cursor: pointer;
    border-radius: 5px;
}
</style>

<body>
    <div class="echec-container">
        <h1>Échec du paiement</h1>
        <p>Nous avons rencontré un problème lors de la validation de votre paiement. Veuillez réessayer.</p>
        <button onclick="window.location.href='../php/panier.php'">Retour au panier</button>
    </div>
</body>
</html>