<?php
session_start();

// Vider le panier en supprimant toutes les données de session
unset($_SESSION['panier']);

// Redirection vers la page du panier
header("Location: panier.php");
exit();
?>