<?php

include ("../Modele/modele.php");
   
$bd= Database::getInstance();

$idUnite = $_POST['unite'];
$qte = $_POST['qte'];
$prix = $_POST['prix'];
$id = $_POST['idproduitFraction'];

$unite = new Unite($bd);
$Lunite = $unite->lire_unite($idUnite);
$produit = new Produit($bd);
$produit->fractionner_produit($id, $Lunite, $qte, $prix);

header("Location: ../Vue/HTML/Fractionnement.php");



?>