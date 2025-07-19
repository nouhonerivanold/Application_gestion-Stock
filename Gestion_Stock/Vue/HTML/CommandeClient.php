<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/CommandeClient.css">
    <script src="../Javascript/CommandeClient.js" defer></script>
    <title>Commande Client</title>
</head>
<body>
    <div class = "content">
        <div class="Client-regulier">
            <span>A travers la barre de recherche ci-dessous retrouver un client regulier</span>
            <div class="bar"></div>
        </div>
        <div class="Header">
            <div class="search-bar">
                <div class="search-content">
                    <input type="text" id="searchInput" placeholder="rechercher un client regulier et cliquer sur lui">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" id="Search">
                        <path d="M46.599 40.236L36.054 29.691C37.89 26.718 39 23.25 39 19.5 39 8.73 30.27 0 19.5 0S0 8.73 0 19.5 8.73 39 19.5 39c3.75 0 7.218-1.11 10.188-2.943l10.548 10.545a4.501 4.501 0 0 0 6.363-6.366zM19.5 33C12.045 33 6 26.955 6 19.5S12.045 6 19.5 6 33 12.045 33 19.5 26.955 33 19.5 33z" fill="#007cb2" class="color000000 svgShape"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bodyside">
            <div class="client-list" id="ClientList">
                <table class="client-table">
                    <tbody>
                        <?php
                        include ('../../Controleur/liste_clients.php');
                        if (isset($liste_clients) && !empty($liste_clients)) {
                            echo "<tr class='client-item'>";
                            echo "<td>Profil</td>";
                            echo "<td class='last-name'>Nom</td>";
                            echo "<td class='first-name'>Prenom</td>";
                            echo "<td class='phone-number'>Telephone</td>";
                            echo "<td class='ville'>Ville</td>";
                            echo "<td class='quatier'>Quartier</td>";
                            echo "<td>Action</td>";
                            echo "</tr>";
                            foreach ($liste_clients as $client) {
                                echo "<tr class='client-item' data-id='{$client['idclient']}'>";
                                echo "<td><img src='../Assets/img.jpeg' alt='photo client' class='client-image'></td>";
                                echo "<td class='last-name'>{$client['nom']}</td>";
                                echo "<td class='first-name'>{$client['prenom']}</td>";
                                echo "<td class='phone-number'>{$client['telephone']}</td>";
                                echo "<td class='ville'>{$client['ville']}</td>";
                                echo "<td class='quatier'>{$client['quartier']}</td>";
                                echo "<td>Modifier</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Aucun client trouvé.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="Client-regulier">
            <span>Renseigner les informations dans les champs ci-dessous s'il est occasionnel</span>
            <div class="bar"></div>
        </div>
        <form action="../../Controleur/commande_client.php" method="POST" class="formulaire">
            <div class="infos-client">
                <div class="info">
                    <label for="firstName">Nom</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>
                <div class="info">
                    <label for="prenom">Prenom:</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                <div class="info">
                    <label for="phone">Téléphone :</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="info">
                    <label for="adresse">Adresse :</label>
                    <input type="text" id="adresse" name="adresse" required>
                </div>
            </div>
            <div class="bouton">
                <button class="bouton-continu" type="submit"  id="passercommande">
                    <span>Suivant</span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_109_8)">
                        <g clip-path="url(#clip1_109_8)">
                        <path d="M23.25 12C23.25 14.1 22.6875 16.0875 21.6375 17.775C20.0625 20.4 17.4375 22.35 14.3625 22.9875C13.6125 23.1375 12.7875 23.25 12 23.25C5.775 23.25 0.75 18.225 0.75 12C0.75 5.775 5.775 0.75 12 0.75C18.225 0.75 23.25 5.775 23.25 12Z" class="coloricon" fill="black"/>
                        <path opacity="0.2" d="M21.6375 17.775C20.0625 20.4 17.4375 22.35 14.3625 22.9875L9 17.625L15.5625 11.6625L21.6375 17.775Z" class="coloricon" fill="black"/>
                        <path d="M9.60001 18C9.30001 18 9.00001 17.8875 8.73751 17.6625C8.25001 17.2125 8.25001 16.425 8.73751 15.975L12.7125 12L8.73751 8.06249C8.25001 7.61249 8.25001 6.82499 8.73751 6.37499C9.18751 5.88749 9.97501 5.88749 10.425 6.37499L15.225 11.175C15.7125 11.625 15.7125 12.4125 15.225 12.8625L10.4625 17.6625C10.2 17.8875 9.90001 18 9.60001 18Z" class="coloricons" fill="white"/>
                        </g>
                        </g>
                        <defs>
                        <clipPath id="clip0_109_8">
                        <rect width="24" height="24" class="coloricon" fill="black"/>
                        </clipPath>
                        <clipPath id="clip1_109_8">
                        <rect width="24" height="24" class="coloricon" fill="black"/>
                        </clipPath>
                        </defs>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</body>
</html>