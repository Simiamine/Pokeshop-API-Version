<?php 
$path = "/".basename(dirname(dirname(__FILE__)));  // Permet d'obtenir le nom du dossier ou sont stocké tout les fichiers
?>

<footer class="footer">
  <div class="footer-content">
    <div class="footer-section">
      <h3>Plan du site</h3>
      <ul>
        <li><a href="<?php echo $path."/index.php";?>">Menu</a></li>
        <li><a href="<?php echo $path."/php/catalogue.php";?>">Catalogue</a></li>
        <li><a href="<?php echo $path."/php/avantage.php";?>">Avantages</a></li>
        <li><a href="<?php echo $path."/php/contact.php";?>">Nous Contacter</a></li>
      </ul>
    </div>
    <div class="footer-section">
      <h3>Mentions Légales</h3>
      <ul>
        <li><a href="#">Conditions d'utilisation</a></li>
        <li><a href="<?php echo $path."/php/politique.php";?>">Politique de confidentialité</a></li>
      </ul>
    </div>
  </div>
</footer>