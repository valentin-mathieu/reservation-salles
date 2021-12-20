<?php

    require ('connexiondb.php');

    $login ="";
    $mdp = "";
    $confirmmdp = "";
    

    if (!empty($_POST)) {
        extract($_POST);
        $valid = (boolean) true;



        if (isset($_POST['inscription'])) {  // SI CLIQUE SUR INSCRIPTION ALORS...

            $login = trim($_POST['login']);
            $mdp= trim($_POST['mdp']);
            $confirmmdp = trim($_POST['confirmmdp']);

            // TESTS DU LOGIN --------------------------------------------------------------------------------------------------------------------

            $testlogin = mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE login = '".$login."'") ; // LOGIN : DEJA UTILISE ?

            $resultlogin = mysqli_num_rows($testlogin) ; // REQUETE SI LOGIN UTILISE

            if(empty($login)) {                                                         // LOGIN : CHAMP VIDE ?

                
                $err_login = "Renseigne ton login s'il te plaît.";
                $valid = false;
                $login="";
            }

            elseif (!preg_match("#^[a-z0-9]+$#" ,$login)) {                               // LOGIN : SANS MAJ, SANS SPEC, MIN ET CHIFFRES OK

                
                $err_login = "Le login doit être renseigné uniquement en lettres miniscules ou chiffres, sans caractères spéciaux." ;
                $valid = false;
                $login="";

            }        
            
            elseif(strlen($login)>25) {                                                 // LOGIN : MAXIMUM 25 CARACTERES                         
                      
                $err_login= "Le login est trop long, il dépasse 25 caractères.";
                $valid= false;
                $login="";
            }



            elseif ($resultlogin == 1) {                                                                                         

                $err_login = "Ce login est déjà utilisé.";
                $valid = false;
                $login="";

            }

            // TESTS MOT DE PASSE  -----------------------------------------------------------------------------------------------------------------

            if(empty($mdp)) {                                                                //  MDP TEST SI VIDE

                $err_mdp = "Renseigne ton mot de passe s'il te plaît.";
                $valid=false;
                $mdp="";
            }


            //                                                  MDP : test ENTRE 8 ET 20 CARACTERES au moins 1 majuscule/miniscule/chiffres/caracspec

            elseif(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$mdp)) {
                $err_mdp = "Le mot de passe ne respecte pas les conditions.";
                $valid = false;
                $mdp="";

            }


            if(empty($confirmmdp)) {                                                               // TEST CONFIRM MDP si vide

                $err_confirmmdp = "Confirme ton mot de passe.";
                $valid = false;
                $confirmmdp="";

            }

            elseif(isset($mdp) && isset($confirmmdp)) {                                                 // TESTS SI MDP ET CONFIRM MDP PAREILS

                if ($mdp != $confirmmdp) {

                    $err_confirm ="Les mots de passe ne correspondent pas.";
                    $valid = false;
                    $confirmmdp="";

                }


            }

            // SI REGLES OK ALORS INSCRIPTION -----------------------------------------------------------------------------------------------------------

            if ($valid) {

                $inscription = "INSERT INTO utilisateurs (login,password) VALUES ('$login','".md5($mdp)."')"; //REQUETE CREATION UTILISATEURS AVEC MDP HACH

                if (mysqli_query($mysqli, $inscription)) {

                    
                    $validation = "Inscription réussie, redirection vers la page de connexion en cours..." ; // EN ATTENDANT HEADER LOCATION//
                    header("Refresh: 3; url=connexion.php");
                    // RAJOUTER HEADER LOCATION VERS CONNEXION
                }

            }

        }

    }

    

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Inscription</title>
        <link rel="stylesheet" href="header.css">
        <link rel="stylesheet" href="footer.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

        <?php require("header.php"); ?>

        <!-- RAJOUTER LA LE HEADER -->

        <main>

            

            <section class="content">
                
                <div><h1 class="titre">INSCRIPTION</h1></div>

                <div> 

                    <p class="intro">
                    Utilise le formulaire ci-dessous pour rejoindre l'aventure.</p>
                    <br><p class="reglesmodifs"> Login : uniquement en lettres miniscules ou chiffres, sans caractères spéciaux, 25 caractères maximum.
                    <br> Mot de passe : entre 8 et 20 caractères, avec au moins 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial.
                    </p>

                </div>
                
                <div class="errform">
                    <?php if (isset($validation)) {echo $validation;} ?>
                </div>
                
                <div class="formplace">

                    <!-- FORMULAIRE DINSCRIPTION -->

                    <form action="inscription.php" method="post" class="styleform">
                        
                        <div class="errform"><?php if (isset($err_login)) { echo $err_login ;} ?></div>
                        <div><input type="text" class="basicinput" name="login" placeholder="Login" value="<?php echo $login ;?>"></div>
                        
                        <div class="errform"><?php if (isset($err_mdp)) { echo $err_mdp ;} ?></div>
                        <div><input type="password" class="basicinput" name="mdp" placeholder="Mot de passe" value="<?php echo $mdp ;?>"></div>

                        <div class="errform"><?php if (isset($err_confirmmdp)) { echo $err_confirmmdp ;} ?></div>
                        <div class="errform"><?php if (isset($err_confirm)) { echo $err_confirm ;} ?></div>
                        <div><input type="password" class="basicinput" name="confirmmdp" placeholder="Confirmez votre mot de passe" value="<?php echo $confirmmdp ;?>"</div>

                        
                        <div><input type="submit" class="submitbtn" name="inscription" value="S'inscrire"><br></div>

                    </form>

                




                    <!-- DEJA INSCRIT ? CONNEXION -->

                    <div class="intro"> Déjà inscrit ? Connecte toi ci-dessous ! </div>

                    <!-- BOUTON LIEN VERS PAGE CONNEXION -->

                    <div><a href="connexion.php"><input type="button" class="submitbtn" value="Connexion"></a></div>

                    

                </div>

            </section>
            
        </main>

        <?php require("footer.php"); ?>




    </body>




</html>

