<header>

    <a href="index.php"><img id="logo_header" width="182px" height="130px" src="Assets/logo_salle.png" alt="logo"></a>
    
    <nav>
        <?php if (!isset($_SESSION['login'])) { ?><a href="inscription.php">INSCRIPTION</a><?php } ?>
        <?php if (!isset($_SESSION['login'])) { ?><a href="connexion.php">CONNEXION</a><?php } ?>
        <a href="planning.php">PLANNING</a>
        <a href="reservation-form.php">RESERVATION</a>
        <?php if (isset($_SESSION['login'])) {?><a href="profil.php">PROFIL</a><?php }?>
        <?php if (isset($_SESSION['login'])) {?><a href="deconnexion.php">DECONNEXION</a><?php }?>
        
        <div id="indicator"></div>
    </nav>
    
</header>

