<?php
include (__DIR__ . "/../Modele/modele.php");

$idProduit = isset($_GET['produit']) ? $_GET['produit'] : null;

$bd = Database::getInstance();
$produit = new Produit($bd);

if ($idProduit) {
    $liste_produits_fractionnes = $produit->produits_fractionnes($idProduit);
} else {
    $liste_produits_fractionnes = [];
}

header('Content-Type: application/json');
echo json_encode($liste_produits_fractionnes);

?>