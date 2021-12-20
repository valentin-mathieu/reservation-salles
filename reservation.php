<?php

require ('connexiondb.php');

session_start();

$sql = mysqli_query($mysqli, "SELECT titre, description, debut, fin FROM reservations WHERE reservations.id = '".@$_GET['val']."'");

$data = mysqli_fetch_assoc($sql);

// Convertit une date ou un timestamp en français
function dateToFrench($date, $format) 
{
    $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
}

$heuredebut = $data['debut'];
$heurefin = $data['fin'];

$jourdebut = dateToFrench($heuredebut ,"l j F Y");
$hdebut = strtotime($heuredebut);
$hfin = strtotime($heurefin);
$debut = date("H:00", $hdebut);
$fin = date("H:00", $hfin);



?>


<html>
    <head>
        <meta charset="utf-8">
        <title>Voir une réservation</title>
        <link rel="stylesheet" href="header.css">
        <link rel="stylesheet" href="footer.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="reservation.css">
    </head>
    <body>

        <?php require("header.php"); ?>

        <main>

            <h1 class="titre">VOIR UNE RÉSERVATION</h1>

            <p class="intro"> Tu peux voir ici les détails d'une réservation.  </p>

            <?php if (isset($_SESSION['login'])) { ?>

            <section class="content">

                <div class="titrejourheure">

                    <div class="boxtitre"><?php echo $data['titre'] ; ?></div>

                    <div class="boxjourheure">
                        
                        <div class="boxjour"><?php echo $jourdebut; ?></div>

                        <div class="boxheure">
                            
                            <div class="heure"><?php echo $debut; ?></div>

                            <div class="heure"><?php echo $fin; ?></div>
                        </div>
                    </div>


                </div>

                <div class="boxdescription">
                    <?php echo $data['description'] ?>
                </div>

            </section>

            <?php } 
                
            else { ?> 

                <section class="nocontent">

                        
                    <p class="intro">Tu dois être connecté pour consulter une réservation. </br>
                        Si tu n'as pas de compte, inscris toi.
                    </p>

                    <form action='inscription.php' method='get'>
                        <button type='submit' class='submitbtn'>Inscription</button>
                    </form>
                

                
                    <form action='connexion.php' method='get'>
                        <button type='submit' class='submitbtn'>Connexion</button>      
                    </form>
                </section>
            
            

            <?php } ?>

              

        </main>

        <?php require("footer.php"); ?>
    
    </body>
</html>