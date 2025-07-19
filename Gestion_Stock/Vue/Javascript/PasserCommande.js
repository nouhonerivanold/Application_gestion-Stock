document.addEventListener('DOMContentLoaded', function() {
    const ajouterBtn = document.getElementById('ajouterPanierBtn');
    const panierList = document.getElementById('panierList');
    const produitSelect = document.getElementById('produit');
    const uniteSelect = document.getElementById('unite');
    const prixInput = document.getElementById('prix');
    const qteInput = document.getElementById('qte');
    const prixTotalGlobalSpan = document.getElementById('prixTotalGlobal');
    const dateInput = document.querySelector('input[type="date"]'); 
    const infosClient = document.getElementById('infosClient');
    let editRow = null;

    const panier = [];
    let uniteData = [];
    var prixTotalGlobal = 0;
    const nom = infosClient.dataset.nom;
    const prenom = infosClient.dataset.prenom;
    const phone = infosClient.dataset.phone;
    const adresse = infosClient.dataset.adresse;

    function updateUnite(){
        // console.log("updateUnite called");
        const produit = parseInt(document.getElementById("produit").value);
        // console.log(produit);
        if (produit) {
            fetch(`../../Controleur/get_unite.php?produit=${produit}`)
                .then(response => {
                    // console.log("reponse: ", response);
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    uniteSelect.innerHTML = ''; // Réinitialiser les options
                    data.forEach(produit => {
                        // console.log(produit);
                        uniteData = data;
                        const option = document.createElement('option');
                        option.value = produit.idunite;
                        option.textContent = produit.unite;
                        uniteSelect.appendChild(option);
                        // prixInput.value = produit['prix']; // Mettre à jour le prix par défaut
                    });
                    if (data.length > 0) {
                        prixInput.value = data[0].prixu;
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des unités:', error));
        } else {
            uniteSelect.innerHTML = ''; // Réinitialiser si aucun produit sélectionné
        }
    }

    produitSelect.addEventListener('change', updateUnite);

    uniteSelect.addEventListener('change', function () {
        const selectedUniteId = uniteSelect.value;
        const selectedUnite = uniteData.find(unite => unite.idunite == selectedUniteId);
        if (selectedUnite) {
            prixInput.value = selectedUnite.prixu; // Mettre à jour le prix
        } else {
            prixInput.value = ''; // Réinitialiser si aucune unité correspondante
        }
    });

    // Fonction pour mettre à jour le prix total global
    function mettreAJourPrixTotalGlobal() {
        let totalGlobal = 0;
        const lignes = panierList.querySelectorAll('tr');
        lignes.forEach(tr => {
            const prixTotalTexte = tr.children[4].textContent.replace(/\s/g, '');
            const prixTotalNombre = Number(prixTotalTexte);
            if (!isNaN(prixTotalNombre)) {
                totalGlobal += prixTotalNombre;
            }
        });
        prixTotalGlobal = parseInt(totalGlobal);
        prixTotalGlobalSpan.textContent = totalGlobal.toLocaleString();
    }

    // Ajouter ou modifier un produit au panier
    ajouterBtn.addEventListener('click', function() {
        const produit = produitSelect.value.trim();
        const unite = uniteSelect.value;
        const prix = prixInput.value.trim();
        const qte = qteInput.value.trim();

        if (!produit || !unite || !prix || !qte || isNaN(prix) || isNaN(qte) || Number(prix) <= 0 || Number(qte) <= 0) {
            alert('Veuillez remplir tous les champs correctement.');
            return;
        }

        const prixTotal = (Number(prix) * Number(qte)).toLocaleString();

        if (editRow) {
            // Modification d'une ligne existante
            editRow.children[0].textContent = produit;
            editRow.children[1].textContent = unite;
            editRow.children[2].textContent = Number(prix).toLocaleString();
            editRow.children[3].textContent = Number(qte);
            editRow.children[4].textContent = prixTotal;
            editRow = null;
            ajouterBtn.textContent = "Ajouter Panier";
            const index = panier.findIndex(item=> item.idProduit ===produit && item.idUnite === unite);
            if (index !== -1) {
                panier[index] = {
                    'idProduit': produit,
                    'idUnite': unite,
                    'prix': Number(prix),
                    'qte': Number(qte)
                };
            }

            mettreAJourPrixTotalGlobal(); // Mise à jour du total global
        } else {
            // Ajout d'une nouvelle ligne
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${produit}</td>
                <td>${unite}</td>
                <td>${Number(prix).toLocaleString()}</td>
                <td>${Number(qte)}</td>
                <td>${prixTotal}</td>
                <td>
                    <button type="button" class="action-btn btn-modifier">Modifier</button>
                    <button type="button" class="action-btn btn-supprimer">Supprimer</button>
                </td>
            `;
            panierList.appendChild(tr);
            panier.push({
                'idProduit':produit,
                'idUnite':unite,
                'prix':Number(prix),
                'qte':Number(qte)
            });

            // Action Modifier
            tr.querySelector('.btn-modifier').addEventListener('click', function() {
                produitSelect.value = tr.children[0].textContent;
                uniteSelect.value = tr.children[1].textContent;
                prixInput.value = tr.children[2].textContent.replace(/\s/g, '');
                qteInput.value = tr.children[3].textContent;
                editRow = tr;
                ajouterBtn.textContent = "Mettre à jour";
            });

            // Action Supprimer
            tr.querySelector('.btn-supprimer').addEventListener('click', function() {
                if (editRow === tr) {
                    editRow = null;
                    ajouterBtn.textContent = "Ajouter Panier";
                }
                tr.remove();

                mettreAJourPrixTotalGlobal(); // Mise à jour du total global après suppression
            });

            mettreAJourPrixTotalGlobal(); // Mise à jour du total global après ajout
        }

        // Réinitialiser les champs
        produitSelect.value = '';
        uniteSelect.value = '';
        prixInput.value = '';
        qteInput.value = '';
    });

    // Gestion de la soumission du formulaire
    document.getElementById('commandeForm').addEventListener('submit', function(e) {
        e.preventDefault(); 

        if (panierList.children.length === 0) {
            alert('Veuillez ajouter au moins un produit au panier.');
            return;
        }
        if (!dateInput.value) {
            alert('Veuillez renseigner la date de la commande.');
            dateInput.focus();
            return;
        }

        console.log('Données envoyees :', {
            panier: panier,
            date: dateInput.value,
            infosClient: {
                'nom': nom,
                'prenom': prenom,
                'phone': phone,
                'adresse': adresse
            }
        });
        
        fetch(`../../Controleur/ajout_commandeClient.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                panier: panier,
                date: dateInput.value,
                infosClient: {
                    nom: nom,
                    prenom: prenom,
                    phone: phone,
                    adresse: adresse
                },
                idClient: document.getElementById('clientId').value
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Réponse du serveur :', data);
            if (data.success) {
                alert('Commande ajoutée avec succès !');
                const statut = 'attente';
                alert('prix total: ' + prixTotalGlobal);
                window.location.href = '../HTML/Facture.php?nom=' + encodeURIComponent(nom) + '&prenom=' + encodeURIComponent(prenom) + '&phone=' + encodeURIComponent(phone) + '&adresse=' + encodeURIComponent(adresse) + '&date=' + encodeURIComponent(dateInput.value) + '&montant=' + encodeURIComponent(prixTotalGlobal) + '&statut=' + encodeURIComponent(statut) + '&produits=' + encodeURIComponent(JSON.stringify(panier));
            } else {
                alert('Erreur lors de l\'ajout de la commande.');
            }
        })
        .catch(error => {
            console.log('Erreur lors de l\'envoi de la commande :', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
        // window.location.href = '../HTML/Facture.html';
    });
});
