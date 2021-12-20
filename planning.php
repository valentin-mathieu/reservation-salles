<?php

    session_start();
    require('connexiondb.php');

    if (isset($_GET['']))
    

    setlocale (LC_TIME, 'fr_FR.utf8','fra');

    $jour = date("w"); // numéro du jour actuel

    if (isset($_GET['reserver'])) {
        header ('Location: reservation-form.php');
    }

    if (isset($_GET['jour'])){
        $jour = intval($_GET['jour']);

    }

    // CREATION AFFICHAGE SEMAINES PRECEDENTE/SUIVANTE ------------------------------------------------------

    if ($_GET['week'] == "pre"){ // Si on veut afficher la semaine précédente
        $jour = $jour + 7;
    }

    elseif ($_GET['week'] == "next"){ // Si on veut afficher la semaine suivante
        $jour = $jour - 7;
    }

    $nom_mois = date("F"); // nom du mois actuel
    $annee = date("Y"); // année actuelle
    $num_week = date("W"); // numéro de la semaine actuelle
    
    
    if (isset($_GET['week'])) {
        $nom_mois = date("F", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
        $annee = date("Y", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
        $num_week = date("W", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
    }

    $dateDebSemaine = date("Y-m-d", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
    $dateFinSemaine = date("Y-m-d", mktime(0,0,0,date("n"),date("d")-$jour+7,date("y")));
    $dateDebSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
    $dateFinSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+7,date("y")));

 



    // CREATION DES VARIABLES JOURS DE LA SEMAINE ET HORAIRES --------------------------------------------------------

    $monday = date('d', strtotime('monday this week'));
    $tuesday = date('d', strtotime('tuesday this week'));
    $wednesday = date('d', strtotime('wednesday this week'));
    $thursday = date('d', strtotime('thursday this week'));
    $friday = date('d', strtotime('friday this week'));

    $semaine = array(0=> $monday, $tuesday, $wednesday, $thursday, $friday);
    $jourTexte =array(0=>'Lundi', 'Mardi', 'Mercredi', 'Jeudi','Vendredi', 'Samedi');

    $huit = '08:00';
    $neuf = '09:00';
    $dix = '10:00';
    $onze = '11:00';
    $douze = '12:00';
    $treize = '13:00';
    $quatorze = '14:00';
    $quinze = '15:00';
    $seize = '16:00';
    $dixsept = '17:00';
    $dixhuit = '18:00';
    $dixneuf = '19:00';

    $plageH = array(0=>'',$huit, $neuf, $dix, $onze,$douze, $treize, $quatorze, $quinze, $seize, $dixsept, $dixhuit, $dixneuf);


    // TRANSFORMATION MOIS ANGLAIS VERS FRANCAIS

    switch($nom_mois){
        case 'January' : $nom_mois = 'Janvier'; break;
        case 'February' : $nom_mois = 'Février'; break;
        case 'March' : $nom_mois = 'Mars'; break;
        case 'April' : $nom_mois = 'Avril'; break;
        case 'May' : $nom_mois = 'Mai'; break;
        case 'June' : $nom_mois = 'Juin'; break;
        case 'July' : $nom_mois = 'Juillet'; break;
        case 'August' : $nom_mois = 'Août'; break;
        case 'September' : $nom_mois = 'Septembre'; break;
        case 'October' : $nom_mois = 'Otober'; break;
        case 'November' : $nom_mois = 'Novembre'; break;
        case 'December' : $nom_mois = 'Décembre'; break;
    }

    // REQUETE SQL 

    $sql = mysqli_query($mysqli, "SELECT utilisateurs.login, reservations.titre, reservations.debut, reservations.fin, reservations.id  FROM `utilisateurs` INNER JOIN reservations ON id_utilisateur=utilisateurs.id");

    $planning = mysqli_fetch_all($sql, MYSQLI_ASSOC);

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Planning</title>
        <link rel="stylesheet" href="header.css">
        <link rel="stylesheet" href="footer.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="planning.css">
    </head>

    <body>

        <?php require('header.php') ; ?>
        
        <main>
        <div class="content">



            <h1 class="titre">PLANNING HEBDOMADAIRE</h1>




            <!-- // EN TETE PLANNING : MOIS + ANNEE -------- -->

            <br/>

            <div id="titre_mois">
                <h2><?php echo $nom_mois ; echo ' '; echo $annee;?></h2>
            </div>

            <?php 
            
            echo '<div id="titreMois" align="center">
            <a class="fleche" href="planning.php?week=pre&jour='.$jour.'"> << </a> 
            Semaine '.$num_week.' 
            <a class="fleche" href="planning.php?week=next&jour='.$jour.'"> >> </a><br />
            du '.$dateDebSemaineFr.' au '.$dateFinSemaineFr.'
            </div>';
            
            ?>

            <!-- // TABLEAU DU PLANNING  ----------------------------------------- -->

            <table class="table" align="center">
                <thead>
                    <th></th>

                <!-- // EN TETE AVEC JOURS SEMAINE EN COURS  -->

                    <?php 

                        for($i =0 ;isset($semaine[$i]) && isset($jourTexte[$i]);$i++) {
                            
                            $weekdate = date("d", mktime(0,0,0,date("n"),date("d")-$jour+$i+1,date("y")));
                            echo '<th id="t_head">'.$jourTexte[$i].' '.$weekdate.'</th>';
                            
                        }
                    ?>

                    </tr>

                </thead>

                <tbody>

                    <?php // COLONNE HORAIRE

                        for ($h=1; isset($plageH[$h]); $h++) { 
                            echo '<tr>';
                            echo '<td id="plage_h">'.$plageH[$h].'</td>';

                            for ($j=0 ; isset($semaine[$j]); $j++) {

                                $weekdate = date("d-m-y", mktime(0,0,0,date("n"),date("d")-$jour+$j+1,date("y")));

                                echo '<td id="empty_td">';

                                foreach($planning as $value) {
                                    $debut = $value['debut'];
                                    $titre = $value['titre'];
                                    $login = $value['login'];
                                    $time = strtotime($debut);
                                    $jourdebut = date("d-m-y", $time);
                                    $heuredebut = date("H:00", $time);

                                    

                                    if ( ($jourdebut == $weekdate) && ($heuredebut == $plageH[$h]))  {
                                        echo '<a id="lienevent" href=reservation.php?val='.$value['id'].'>';
                                        echo '<div class="titreevent">'.$titre.'</div>' ;
                                        echo '<div class="loginevent">'.$login.'</div>' ;
                                        echo '</a>';
                                    }
                                }

                            }
                        } 
                    ?>
                    
                </tbody>
            </table>

        </div>

        <?php if (isset($_SESSION['login'])) { ?>

        <form action='planning.php' method='get'>
            <button type='submit' class='submitbtn' name="reserver">Réserver</button>      
        </form>

        <?php } ?>

        </main>

        <?php require('footer.php');?>
    
    </body>

</html>