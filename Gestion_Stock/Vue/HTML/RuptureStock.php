<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/RuptureStock.css">
    <script src="../Javascript/RuptureStock.js" defer></script>
    <title>Produit en Rupture de Stock</title>
</head>
<body>
    <div class = "content">
        <div class="Header">
            <div class="search-bar">
                <div class="search-content">
                    <input type="text" id="searchInput" placeholder="rechercher un Produit parmi ceux en rupture de stock">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" id="Search">
                        <path d="M46.599 40.236L36.054 29.691C37.89 26.718 39 23.25 39 19.5 39 8.73 30.27 0 19.5 0S0 8.73 0 19.5 8.73 39 19.5 39c3.75 0 7.218-1.11 10.188-2.943l10.548 10.545a4.501 4.501 0 0 0 6.363-6.366zM19.5 33C12.045 33 6 26.955 6 19.5S12.045 6 19.5 6 33 12.045 33 19.5 26.955 33 19.5 33z" fill="#007cb2" class="color000000 svgShape"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bodyside">
            <div class="produit-list" id="productList">
                <table class="client-table">
                    <tbody>
                        <?php
                        include("../../Controleur/liste_produits.php");
                        if(isset($liste_produits_rupture) && !empty($liste_produits_rupture)){
                            echo "<tr class='client-item'>";
                            echo "<td>Image</td>";
                            echo "<td class='libelle'>Libelle</td>";
                            echo "<td class='prix-unitaire'>Prix</td>";
                            echo "<td class='qteStock'>Quantite</td>";
                            echo "<td class='seuil'>Seuil</td>";
                            echo "</tr>";
                            foreach ($liste_produits_rupture as $produit) {
                                echo "<tr class='client-item'>";
                                echo "<td><img src='../Images/{$produit['image']}' alt='photo produit' class='client-image'></td>";
                                echo "<td class='libelle'>{$produit['libelle']}</td>";
                                echo "<td class='prix-unitaire'>{$produit['prixu']}</td>";
                                echo "<td class='qteStock'>{$produit['qtestock']}</td>";
                                echo "<td class='seuil'>{$produit['qtemin']}</td>";
                                echo "</tr>";
                            } 
                        } else {
                                echo "<tr><td colspan='6'>Aucun produit trouvé.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  
</body>
</html>