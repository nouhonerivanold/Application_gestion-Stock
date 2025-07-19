<?php
include (__DIR__ . "/../Modele/modele.php");

$bd= Database::getInstance();

$produit = new Produit($bd);
$unite = new Unite($bd);
$client = new Client($bd);
$fournisseur = new Fournisseur($bd);
$facture = new FactureClient($bd);
$commandes = new Commande($bd);

$liste_unites = $unite->liste_unites();
$liste_produits = $produit->liste_produits();
$liste_produits_rupture = $produit->liste_produits_ruptureStock();
$liste_clients = $client->liste_clients();
$liste_fournisseurs = $fournisseur->liste_fournisseurs();
$liste_factures_nonCompletes = $facture->liste_factures_nonCompletes();
$liste_factures = $facture->liste_factures();
?>