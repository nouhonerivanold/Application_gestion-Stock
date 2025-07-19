<?php
include (__DIR__ . "/../Modele/modele.php");

$bd = Database::getInstance();
$commande = new Commande($bd);
$produit = new Produit($bd);
$ligneCommande = new LigneCommande($bd);
$facture = new FactureClient($bd);
// Lire le corps brut de la requête
$rawData = file_get_contents('php://input');

// Décoder les données JSON
$data = json_decode($rawData, true);

// Vérifier si les données ont été correctement décodées
if ($data === null) {
    http_response_code(400); // Mauvaise requête
    echo json_encode(['error' => 'Données JSON invalides']);
    exit();
}

// Récupérer les données du panier et la date
$panier = $data['panier'] ?? [];
$date = $data['date'] ?? null;
$infosClient = $data['infosClient'] ?? [];
$idClient = !empty($data['idClient']) ? $data['idClient'] : null;

$idCommande = $commande->ajout_commande($date);
if($idCommande === false) {
    http_response_code(500); // Erreur interne du serveur
    echo json_encode(['error' => 'Échec de l\'ajout de la commande']);
    exit();
}
else{
    $sommeTotale = 0;
    // Ajouter les produits du panier à la commande
    
    foreach ($panier as $produit_panier) {
        $Leproduit = $produit->lire_produit_unite($produit_panier['idProduit'], $produit_panier['idUnite']);
        if ($Leproduit === false) {
            http_response_code(404); // Produit non trouvé
            echo json_encode(['error' => 'Produit non trouvé']);
            exit();
        }
        else{
            $ligneCommande->ajout_ligneCommande($Leproduit['idproduit'], $idCommande, $produit_panier['qte']);
            $sommeTotale += $Leproduit['prixu'] * $produit_panier['qte'];
        }
    }
    if($idClient === null) {
        $facture->creer_facture($idCommande, $sommeTotale, $sommeTotale, "attente", $date, $infosClient);
    }
    else{
        $facture->creer_facture($idCommande, $sommeTotale, $sommeTotale, "attente", $date, $infosClient, $idClient);
    }
}

// Debug : Afficher les données reçues
error_log("Panier : " . print_r($panier, true));
error_log("Date : " . $date);
error_log("Infos Client : " . print_r($infosClient, true));

// Retourner une réponse JSON
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>