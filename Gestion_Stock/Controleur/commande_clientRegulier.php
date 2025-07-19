<?php
include (__DIR__ . "/../Modele/modele.php");

$bd = Database::getInstance();
$produits = new Produit($bd);

try {
    $liste_produits = $produits->liste_produits();

    if ($liste_produits === null) {
        throw new Exception("Aucun produit trouvé.");
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'produits' => $liste_produits]);
} catch (Exception $e) {
    header('Content-Type: application/json', true, 500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>