<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/PasserCommande.css">
    <script src="../Javascript/PasserCommande.js" defer></script>
    <title>Commande d'un client</title>
</head>
<body>
    <div class="content">
         <div class="passer-commande">
            <span>Enregistrer la commande du client</span>
            <div class="bar"></div>
        </div>
        <div class="bodyside">
            <?php
                $nom = isset($_GET['nom']) ? urldecode($_GET['nom']) : '';
                $prenom = isset($_GET['prenom']) ? urldecode($_GET['prenom']) : '';
                $phone = isset($_GET['phone']) ? urldecode($_GET['phone']) : '';
                $adresse = isset($_GET['adresse']) ? urldecode($_GET['adresse']) : '';
                $liste_produits = isset($_GET['produits']) ? json_decode(urldecode($_GET['produits']), true) : [];
            ?>
            <form id="commandeForm" >
                <input type="hidden" id="clientId" value="<?php echo htmlspecialchars($_GET['idClient'] ?? ''); ?>">
                <div class="info-client">
                    <label for="nom">Nom client concerne :</label>
                    <input type="text" value="<?php echo htmlspecialchars($nom).' '. htmlspecialchars($prenom); ?>" readonly>
                    <input type="hidden" id="infosClient" data-nom="<?php echo htmlspecialchars($nom); ?>" data-prenom="<?php echo htmlspecialchars($prenom); ?>" data-phone="<?php echo htmlspecialchars($phone); ?>" data-adresse="<?php echo htmlspecialchars($adresse); ?>">
                </div> 
                <div class="commande">
                    <div class="form-container">
                            <div class="left">
                                <div class="info">
                                    <label for="produit">Produit a Commander</label>
                                    <select id="produit">
                                        <option value="" selected disabled>-- Choisir un produit  --</option>
                                        <?php
                                        if (!empty($liste_produits)) {
                                            foreach ($liste_produits as $produit) {
                                                echo "<option value='{$produit['idproduit']}'>{$produit['libelle']}</option>";
                                            }
                                        }
                                        else {
                                            echo "<option value=''>Aucun produit</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="info">
                                    <label for="unite">Unité</label>
                                    <select id="unite" >
                                        <option value="" selected disabled>-- Choisir une unité --</option>
                                    </select>
                                </div>
                                <div class="info">
                                    <label for="prix">Prix Unitaire</label>
                                    <input type="number" id="prix" min="0" disabled>
                                </div>
                                <div class="info">
                                    <label for="qte">Quantité</label>
                                    <input type="number" id="qte" placeholder="50" min="1">
                                </div>
                                <button type="button" id="ajouterPanierBtn">Ajouter Panier</button>
                            </div>
                            <div class="vertical-line"></div>
                            <div class="right">
                                <h2>Panier des commandes</h2>
                                <div class="list-produit">
                                    <table class="produit-table">
                                        <thead>
                                            <tr>
                                                <th>Produit</th>
                                                <th>Unité</th>
                                                <th>Prix Unitaire</th>
                                                <th>Quantité</th>
                                                <th>Prix total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="panierList">
                                            <!-- Les produits ajoutés s'affichent ici -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="prix-total-container" style="margin-top: 1em; font-weight: bold; font-size: 1.2em;">
                                    Prix total global : <span id="prixTotalGlobal" style="color: red; font-weight: 800;">0</span> FCFA
                                </div>
                            </div>
                    </div>
                </div>
                <div class="info-client">
                    <label for="date">Date Commande :</label>
                    <input type="date" placeholder="renseigner la date de la commande" >
                </div>
                <div class="button-group">
                    <button type="submit" class="btn btn-ajouter" >Enregistrer</button>
                    <button type="reset" class="btn-cancel">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>