<?php
include (__DIR__ . "/../Modele/modele.php");

$bd = Database::getInstance();
$produits = new Produit($bd);

$nom = $_POST['firstName'];
$prenom = $_POST['prenom'];
$phone = $_POST['phone'];
$adresse = $_POST['adresse'];

$liste_produits = $produits->liste_produits();

$produits_json = urlencode(json_encode($liste_produits));
$nom = urlencode($nom);
$prenom = urlencode($prenom);
$phone = urlencode($phone);
$adresse = urlencode($adresse);

header("Location: ../Vue/HTML/PasserCommande.php?nom=$nom&prenom=$prenom&phone=$phone&adresse=$adresse&produits=$produits_json");
exit();
?>