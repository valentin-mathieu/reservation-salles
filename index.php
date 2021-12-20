<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="index.css">
  </head>
<body>

<?php require("header.php"); ?>

<main>

    <div class="p_accueil">
    <p id="p_neon"><b> BIENVENUE CHEZ VIRTUALROOM </b></p>
    <p> ------------------------- </p>
    <p id="p_neon2"> Une salle, pour une infinité d'expériences... </p>
    </div>
    <a href="reservation-form.php"><img id="bouton_reservation" height="220px" width="220px" src="Assets/bouton_reservation.png" alt="reservation"></a>
    
    <div id="carroussel"> 
          <div class="img_vr">
            <img src="Assets/carroussel1.png" alt="vr1">
            <img src="Assets/carroussel2.png" alt="vr2">
            <img src="Assets/carroussel3.png" alt="vr3">
            <img src="Assets/carroussel4.png" alt="vr4">
            <img src="Assets/carroussel5.png" alt="vr5">
          </div>
    </div>
</main>

<?php require("footer.php"); ?>

</body>
</html>