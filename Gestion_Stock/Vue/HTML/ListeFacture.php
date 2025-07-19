<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/ListeFacture.css">
    <script src="../Javascript/ListeFacture.js" defer></script>
    <title>Clients & Factures</title>
</head>
<body>
    <?php
    include ("../../Controleur/liste_facture.php");
    ?>
    <div class="content">
        <div class="Header">
            <div class="search-bar">
                <div class="search-content">
                    <input type="text" id="searchInput" placeholder="Rechercher un client">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" id="Search">
                        <path d="M46.599 40.236L36.054 29.691C37.89 26.718 39 23.25 39 19.5 39 8.73 30.27 0 19.5 0S0 8.73 0 19.5 8.73 39 19.5 39c3.75 0 7.218-1.11 10.188-2.943l10.548 10.545a4.501 4.501 0 0 0 6.363-6.366zM19.5 33C12.045 33 6 26.955 6 19.5S12.045 6 19.5 6 33 12.045 33 19.5 26.955 33 19.5 33z" fill="#007cb2"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bodyside">
            <div class="client-list" id="ClientList">
                <?php
                if (isset($liste_clients) && !empty($liste_clients)) {
                    echo "<div class='client-item'>";
                    echo "<span class='client-header'>Clients</span>";
                    echo "</div>";
                    foreach ($liste_clients as $client) {
                        echo "<div class='client-card'>";
                        echo "<div class='client-header'>";
                        echo "<img src='../Assets/img.jpeg' alt='photo client' class='client-image'>";
                        echo "<span class='client-name'>{$client['nom']} {$client['prenom']}</span>";
                        echo "<button class='toggle-factures'>Voir factures ▼</button>";
                        echo "</div>";
                        echo "<div class='factures-list'>";
                        foreach ($liste_factures_nonCompletes as $facture) {
                            if ($facture['idclient'] == $client['idclient']) {
                                echo "<div class='facture-item'>";
                                echo "<span class='facture-date'>{$facture['date']}</span>";
                                $statut_class = $facture['statut'] === 'totale' ? 'statut-payee' : ($facture['statut'] === 'attente' ? 'statut-nonpayee' : 'statut-partielle');
                                echo "<span class='facture-statut {$statut_class}'>{$facture['statut']}</span>";
                                echo "<button class='btn-details' onclick=\"window.location.href='../HTML/Facture.php?facture_id={$facture['idfacture']}'\">Détails</button>";
                                echo "</div>";
                            }
                        }
                        echo "</div>";
                    echo "</div>";
                    }
                } else {
                    echo "<div class='client-item'>Aucun client trouvé.</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
