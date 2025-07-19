<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Client.css">
    <script src="../Javascript/Client.js" defer></script>
    <title>Clients</title>
</head>
<body>
    <div class = "content">
        <div class="Header">
            <div class="search-bar">
                <div class="search-content">
                    <input type="text" id="searchInput" placeholder="rechercher un client">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" id="Search">
                        <path d="M46.599 40.236L36.054 29.691C37.89 26.718 39 23.25 39 19.5 39 8.73 30.27 0 19.5 0S0 8.73 0 19.5 8.73 39 19.5 39c3.75 0 7.218-1.11 10.188-2.943l10.548 10.545a4.501 4.501 0 0 0 6.363-6.366zM19.5 33C12.045 33 6 26.955 6 19.5S12.045 6 19.5 6 33 12.045 33 19.5 26.955 33 19.5 33z" fill="#007cb2" class="color000000 svgShape"></path>
                    </svg>
                </div>
            </div>
            <button>
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_74_4)">
                    <path d="M12.99 25.98C5.81627 25.98 0 20.1637 0 12.99C0 5.81627 5.81627 0 12.99 0C20.1637 0 25.98 5.81627 25.98 12.99C25.98 20.1637 20.1637 25.98 12.99 25.98ZM12.99 3.2475C7.61052 3.2475 3.2475 7.61052 3.2475 12.99C3.2475 18.3695 7.61052 22.7325 12.99 22.7325C18.3695 22.7325 22.7325 18.3695 22.7325 12.99C22.7325 7.61052 18.3695 3.2475 12.99 3.2475ZM17.8612 14.6137H14.6137V17.8612C14.6137 18.7592 13.8879 19.485 12.99 19.485C12.5594 19.485 12.1463 19.3139 11.8418 19.0094C11.5373 18.7049 11.3662 18.2919 11.3662 17.8612V14.6137H8.11875C7.6881 14.6137 7.2751 14.4427 6.97059 14.1382C6.66607 13.8337 6.495 13.4206 6.495 12.99C6.495 12.5594 6.66607 12.1463 6.97059 11.8418C7.2751 11.5373 7.6881 11.3662 8.11875 11.3662H11.3662V8.11875C11.3772 7.69536 11.5531 7.29299 11.8564 6.9974C12.1597 6.70181 12.5665 6.53639 12.99 6.53639C13.4135 6.53639 13.8203 6.70181 14.1236 6.9974C14.4269 7.29299 14.6028 7.69536 14.6137 8.11875V11.3662H17.8612C18.2919 11.3662 18.7049 11.5373 19.0094 11.8418C19.3139 12.1463 19.485 12.5594 19.485 12.99C19.485 13.8879 18.7592 14.6137 17.8612 14.6137Z" class="coloricon" fill="black"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_74_4">
                    <rect width="25.98" height="25.98" class="coloricon" fill="black"/>
                    </clipPath>
                    </defs>
                </svg>
                <span>Ajouter Client</span>
            </button>
        </div>
        <div class="bodyside">
            <div class="client-list" id="ClientList">
                <table class="client-table">
                    <tbody>
                        <?php 
                            include ("../../Controleur/liste_clients.php");
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
                                    echo "<tr class='client-item'>";
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
    </div>

    <!-- ========================== ici nous allons gerer le popup du client =================== -->

        <div id="modalClient" class="modal">
            <div class="form-container">
                <span class="close-modal" id="closeModalBtn">&times;</span>
                <h1>Ajout client</h1>
                <form action="../../Controleur/ajout_client.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom du client</label>
                    <input type="text" id="nom" name="nom" placeholder="entrez le nom" />
                </div>
                <div class="form-group">
                    <label for="prenom">Prenom du client</label>
                    <input type="text" id="prenom" name="prenom" placeholder="entrez le prenom" />
                </div>
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <input type="text" id="telephone" name="telephone" placeholder="659338420" />
                </div>
                <div class="form-group">
                    <label for="ville">Ville</label>
                    <input type="text" id="ville" name="ville" placeholder="Bafoussam" />
                </div>
                <div class="form-group">
                    <label for="quartier">Quartier</label>
                    <input type="text" id="quartier" name="quartier" placeholder="Madelon" />
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-add">ajouter</button>
                    <button type="reset" class="btn-cancel">Annuler</button>
                </div>
                </form>
            </div>
        </div>

    <!-- ========================== ici nous allons gerer le popup du client =================== -->
</body>
</html>