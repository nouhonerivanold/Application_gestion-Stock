<?php

include ("../models/Modele.php");
   
    $bd= Database::getInstance();
    $id_produit=$_POST["id_produit"];
    $commande = $_POST["id_commande"];
    $qte=$_POST["qte"];

    $bureau = new Adherent($bd);
    $bureau->InsererAdherent($nom, $adresse);

?>