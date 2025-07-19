document.addEventListener('DOMContentLoaded', function() {
    const ajouterBtn = document.getElementById('ajouterPanierBtn');
    const panierList = document.getElementById('panierList');
    const produitSelect = document.getElementById('produit');
    const uniteSelect = document.getElementById('unite');
    const qteInput = document.getElementById('qte');
    const dateInput = document.querySelector('input[type="date"]');
    let editRow = null;

    // Ajouter ou modifier un produit au panier
    ajouterBtn.addEventListener('click', function() {
        const produit = produitSelect.value.trim();
        const unite = uniteSelect.value;
        const qte = qteInput.value.trim();

        if (!produit || !unite || !qte || isNaN(qte) || Number(qte) <= 0) {
            alert('Veuillez remplir tous les champs correctement.');
            return;
        }

        if (editRow) {
            // Modification d'une ligne existante
            editRow.children[0].textContent = produit;
            editRow.children[1].textContent = unite;
            editRow.children[2].textContent = Number(qte);
            editRow = null;
            ajouterBtn.textContent = "Ajouter Panier";
        } else {
            // Ajout d'une nouvelle ligne
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${produit}</td>
                <td>${unite}</td>
                <td>${Number(qte)}</td>
                <td>
                    <button type="button" class="action-btn btn-modifier">Modifier</button>
                    <button type="button" class="action-btn btn-supprimer">Supprimer</button>
                </td>
            `;
            panierList.appendChild(tr);

            // Action Modifier
            tr.querySelector('.btn-modifier').addEventListener('click', function() {
                produitSelect.value = tr.children[0].textContent;
                uniteSelect.value = tr.children[1].textContent;
                qteInput.value = tr.children[2].textContent;
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
            });
        }

        // Réinitialiser les champs
        produitSelect.value = '';
        uniteSelect.value = '';
        qteInput.value = '';
    });

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
        window.location.href = '../HTML/BonCommande.html';
    });

});
