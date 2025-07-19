<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture d'un Client</title>
    <link rel="stylesheet" href="../CSS/Facture.css">
</head>
<body>
    <button id="downloadBtn" class="download-btn">Télécharger la facture</button>
    <div class="facture-conteneur" id="factureConteneur">
        <div class="entete-facture">
            <div class="nom-entreprise">STOCKSYS</div>
        </div>
        <div class="corps-facture">
            <div class="infos-client-commande">
                <div class="infos-client">
                    <strong>À :</strong> <strong><?php echo htmlspecialchars($_GET['nom']). ' ' .htmlspecialchars($_GET['prenom']); ?></strong><br>
                    <?php echo htmlspecialchars($_GET['adresse']); 
                    echo "<br>";
                    echo htmlspecialchars($_GET['phone']);
                    ?><br>
                </div>
                <div class="infos-commande">
                    <strong>Date d'émission :</strong> <?php echo htmlspecialchars($_GET['date']); ?><br>
                    <strong>Statut :</strong> <span id="etat-facture" class="statut-cloture"><?php echo isset($_GET['statut']) ? htmlspecialchars($_GET['statut']) : 'Non défini'; ?></span>
                </div>
            </div>
            <table class="table-articles">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Quantité</th>
                        <th>Unite</th>
                        <th>Prix Unitaire</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $produits = isset($_GET['produits']) ? json_decode($_GET['produits'], true) : [];
                    if (is_array($produits) && count($produits) > 0) {
                        foreach ($produits as $index => $produit) {
                            echo "<tr>";
                            echo "<td>" . ($index + 1) . "</td>";
                            echo "<td>" . htmlspecialchars($produit['idProduit']) . "</td>";
                            echo "<td>" . htmlspecialchars($produit['qte']) . "</td>";
                            echo "<td>" . htmlspecialchars($produit['idUnite']) . "</td>";
                            echo "<td>" . htmlspecialchars($produit['prix']) . "<br><span class='devise'>CFA</span></td>";
                            echo "<td>" . htmlspecialchars($produit['prix'] * $produit['qte']) . "<br><span class='devise'>CFA</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Aucun produit trouvé.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="total-section">
                <div class="total-libelle">Montant total :</div>
                <div class="total-valeur"><?php echo isset($_GET['montant']) ? htmlspecialchars($_GET['montant']) : '0'; ?><br><span class="devise">CFA</span></div>
                <input type="hidden" id="montant-total" value="<?php echo isset($_GET['montant']) ? htmlspecialchars($_GET['montant']) : '0'; ?>">
            </div>
            <div class="montant-percu">
                <div class="mont">
                    <div class="montant-percu-libelle">Montant perçu :</div>
                    <input type="number" id="montant-percu" class="montant-percu-valeur" value="0">
                </div>
                <div class="mont">
                    <div class="montant-percu-libelle">Montant Restant :</div>
                    <input type="text" id="montant-restant" class="montant-restant-valeur" value="0" readonly>
                </div>
            </div>
            <div class="signature">
                <p>Signature Vendeur</p>
                <p>Signature Client</p>
            </div>
            <div class="message-footer">
                Merci d'avoir acheté vos produits chez STOCKSYS !<br>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="../Javascript/Facture.js"></script>
</body>
</html>