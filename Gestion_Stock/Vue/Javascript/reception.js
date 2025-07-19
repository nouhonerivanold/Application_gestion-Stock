// --- Initialisation dynamique du panier à partir du HTML ---
let panierProduits = [];
let produitsRecus = [];
let produitSelectionne = null;

// Conversion du tableau HTML en tableau JS d'objets
function initPanierFromTable() {
    const rows = document.querySelectorAll('#panierList tr');
    panierProduits = [];
    rows.forEach(row => {
        const tds = row.querySelectorAll('td');
        panierProduits.push({
            produit: tds[0].textContent.trim(),
            unite: tds[1].textContent.trim(),
            quantite: Number(tds[2].textContent.trim())
        });
    });
}

// Rendu du panier dans le tableau HTML
function renderPanier() {
    const tbody = document.getElementById('panierList');
    tbody.innerHTML = '';
    panierProduits.forEach((item, idx) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.produit}</td>
            <td>${item.unite}</td>
            <td>${item.quantite}</td>
            <td>
                <button type="button" class="action-btn" data-idx="${idx}">Receptionner</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// Rendu du panier des produits reçus
function renderReception() {
    const tbody = document.getElementById('receptionList');
    tbody.innerHTML = '';
    let total = 0;
    produitsRecus.forEach(item => {
        const prixTotal = item.quantite * item.prixAchat;
        total += prixTotal;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.produit}</td>
            <td>${item.unite}</td>
            <td>${item.quantite}</td>
            <td>${item.prixAchat.toFixed(2)}</td>
            <td>${prixTotal.toFixed(2)}</td>
        `;
        tbody.appendChild(tr);
    });
    document.getElementById('prixTotalReception').textContent = total.toFixed(2);
}

// Réinitialisation du formulaire de fractionnement
function resetFractionForm() {
    document.getElementById('produitForm').value = '';
    document.getElementById('uniteForm').value = '';
    document.getElementById('qteCommandeForm').value = '';
    document.getElementById('qteRecuForm').value = '';
    document.getElementById('prixAchatForm').value = '';
    document.getElementById('enregistrerFractionBtn').disabled = true;
    produitSelectionne = null;
}

// --- Gestion des événements ---
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du panier à partir du tableau HTML existant
    initPanierFromTable();
    renderPanier();
    renderReception();
    resetFractionForm();

    // Click sur Receptionner
    document.getElementById('panierList').addEventListener('click', function(e) {
        if (e.target.classList.contains('action-btn')) {
            const idx = Number(e.target.dataset.idx);
            const prod = panierProduits[idx];
            produitSelectionne = { ...prod, idx };
            document.getElementById('produitForm').value = prod.produit;
            document.getElementById('uniteForm').value = prod.unite;
            document.getElementById('qteCommandeForm').value = prod.quantite;
            document.getElementById('qteRecuForm').value = '';
            document.getElementById('prixAchatForm').value = '';
            document.getElementById('enregistrerFractionBtn').disabled = false;
            document.getElementById('qteRecuForm').focus();
        }
    });

    // Validation du formulaire de fractionnement
    document.getElementById('enregistrerFractionBtn').addEventListener('click', function() {
        if (!produitSelectionne) return;
        const qteCommande = Number(document.getElementById('qteCommandeForm').value);
        const qteRecu = Number(document.getElementById('qteRecuForm').value);
        const prixAchat = Number(document.getElementById('prixAchatForm').value);

        if (!qteRecu || qteRecu <= 0 || qteRecu > qteCommande) {
            alert("Quantité reçue invalide.");
            return;
        }
        if (!prixAchat || prixAchat <= 0) {
            alert("Prix d'achat invalide.");
            return;
        }

        // Ajout au panier des produits reçus
        produitsRecus.push({
            produit: produitSelectionne.produit,
            unite: produitSelectionne.unite,
            quantite: qteRecu,
            prixAchat: prixAchat
        });

        // Mise à jour du panier principal
        if (qteRecu === qteCommande) {
            panierProduits.splice(produitSelectionne.idx, 1);
        } else {
            panierProduits[produitSelectionne.idx].quantite -= qteRecu;
        }

        renderPanier();
        renderReception();
        resetFractionForm();
    });

    // Désactivation du bouton Enregistrer si pas de produit sélectionné
    document.getElementById('fractionForm').addEventListener('input', function() {
        const qteRecu = Number(document.getElementById('qteRecuForm').value);
        const prixAchat = Number(document.getElementById('prixAchatForm').value);
        document.getElementById('enregistrerFractionBtn').disabled = !(qteRecu > 0 && prixAchat > 0 && produitSelectionne);
    });

    // Validation finale
    document.getElementById('validationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const dateReception = document.getElementById('dateReception').value;
        if (produitsRecus.length === 0) {
            alert("Veuillez recevoir au moins un produit.");
            return;
        }
        if (!dateReception) {
            alert("Veuillez renseigner la date de réception.");
            document.getElementById('dateReception').focus();
            return;
        }
        alert("Réception enregistrée avec succès !");
        // Ici, on pourrait envoyer les données au serveur ou passer à une autre page
        // window.location.href = '...';
    });
});
