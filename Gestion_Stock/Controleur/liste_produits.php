<?php
include (__DIR__ . "/../Modele/modele.php");

$bd= Database::getInstance();

$produit = new Produit($bd);
$unite = new Unite($bd);

$liste_unites = $unite->liste_unites();
$liste_produits = $produit->liste_produits();
$liste_produits_rupture = $produit->liste_produits_ruptureStock();

?>