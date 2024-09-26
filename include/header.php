<?php 
$path = "/".basename(dirname(dirname(__FILE__)));  // Permet d'obtenir le nom du dossier ou sont stocké tout les fichiers
?>
<header>
<section id="header">
    <div class="logo">
        <a href="<?php echo $path."/index.php";?>"><img src="<?php echo $path."/img/icon.png";?>" alt="pokeball" class = "logo" width="50"></a>
    </div>
    <div>
        <ul id="navbar">
            <?php if (isset($_SESSION['user_statut']) && $_SESSION['user_statut'] == 'client'){ ?>
            <li>Bonjour, <?= htmlspecialchars($_SESSION['user_name']); ?></li>
            
            <li><a href="<?php echo $path."/index.php";?>" id="menu" class="ligne-header" >Menu</a></li>
            <li><a href="<?php echo $path."/php/catalogue.php";?>" id="catalogue" class="ligne-header">Catalogue</a></li>
            <li><a href="<?php echo $path."/php/pokedex.php";?>" id="pokedex" class="ligne-header">Pokedex</a></li>
            <li><a href="<?php echo $path."/php/client/compte_client.php";?>" id="compte" class="ligne-header">Compte</a></li>
            <li><a href="<?php echo $path."/php/deconnexion.php";?>" id="deconnexion">Déconnexion</a></li>
            <!-- j'ai modifié -->
            <li><a id="panier" class="ligne-header" href="<?php echo $path."/php/panier.php";?>"> <i class="fa-solid fa-bag-shopping fa-xl"></i> <span id="panierCount"><?php echo isset($_SESSION['panier'])? count($_SESSION['panier']) : 0; ?></span></a></li> 


            <?php }elseif(isset($_SESSION['user_statut']) && $_SESSION['user_statut'] == 'admin'){ ?>
            <li>Compte_Admin </li>
            <li><a href="<?php echo $path."/index.php";?>" id="menu" class="ligne-header">Menu</a></li>
            <li><a href="<?php echo $path."/php/admin/analyse.php";?>" id="ajtPokemon" class="ligne-header">Analyse</a></li>
            <li><a href="<?php echo $path."/php/admin/ajout_pok.php";?>" id="pokemon" class="ligne-header"> Pokemons</a></li>
            <li><a href="<?php echo $path."/php/admin/afficher_commande.php";?>" id="commande" class="ligne-header">Commandes</a></li>
            <li><a href="<?php echo $path."/php/deconnexion.php";?>" id="deconnexion">Déconnexion</a></li>

            <?php }else{ ?>
            <li><a href="<?php echo $path."/index.php";?>" id="menu" class="ligne-header">Menu</a></li>
            <li><a href="<?php echo $path."/php/catalogue.php";?>" id="catalogue" class="ligne-header">Catalogue</a></li>
            <li><a href="<?php echo $path."/php/avantage.php";?>" id="avantage" class="ligne-header">Avantages</a></li>
            <li><a href="<?php echo $path."/php/contact.php";?>" id="contact" class="ligne-header">Contact</a></li>
            <li><a href="<?php echo $path."/php/login.php";?>" id="connexion" class="ligne-header">Connexion</a></li>
            <!-- j'ai modifié -->
            <li><a id="panier" class="ligne-header" href="<?php echo $path."/php/panier.php";?>"> <i class="fa-solid fa-bag-shopping fa-xl"></i> <span id="panierCount"><?php echo isset($_SESSION['panier'])? count($_SESSION['panier']) : 0; ?></span></a></li>  

            <?php } ?>
        </ul>
    </div>
</section>
</header>