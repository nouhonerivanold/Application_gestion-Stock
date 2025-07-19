<?php

include ("../Modele/modele.php");
   
$bd= Database::getInstance();

$intitule = $_POST['intitule'];

$unite = new Unite($bd);

$unite->ajout_unite($intitule);

header("Location: ../Vue/HTML/Fractionnement.php");
?>