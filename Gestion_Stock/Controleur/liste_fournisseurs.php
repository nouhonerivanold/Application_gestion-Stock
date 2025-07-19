<?php

include (__DIR__ . "/../Modele/modele.php");
   
$bd= Database::getInstance();

$fournisseur = new Fournisseur($bd);
$liste_fournisseurs = $fournisseur->liste_fournisseurs();

?>