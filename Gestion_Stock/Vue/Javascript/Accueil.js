
// ====================implementation de l'iframe==================
document.getElementById('btnAccueil').onclick = function() {
    document.getElementById('mainFrame').src = '../HTML/HomePage.php';
};
document.getElementById('btnProduits').onclick = function() {
    document.getElementById('mainFrame').src = '../HTML/Produits.php';
};
document.getElementById('btnFactures').onclick = function() {
    document.getElementById('mainFrame').src = '../HTML/ListeFacture.php';
};
document.getElementById('btnFournisseurs').onclick = function() {
    document.getElementById('mainFrame').src = '../HTML/Fournisseur.php';
};
document.getElementById('btnClients').onclick = function() {
    document.getElementById('mainFrame').src = '../HTML/Client.php';
};
document.getElementById('commandeClient').onclick = function() {
    document.getElementById('mainFrame').src = '../HTML/CommandeClient.php';
};
document.getElementById('commandeFournisseur').onclick = function() {
    document.getElementById('mainFrame').src = '../HTML/CommandeFournisseur.php';
};
 document.getElementById('btnFractionnement').onclick = function() {
    document.getElementById('mainFrame').src = '../HTML/Fractionnement.php';
};
document.getElementById('btnReception').onclick = function() {
    document.getElementById('mainFrame').src = '../HTML/CommandePasser.html';
};


// ====================end implementation de l'iframe====================

// ====================implementation du dropdown==================

document.getElementById('btnCommandes').addEventListener('click', function(e) {
    e.stopPropagation();
    const dropdown = this.parentElement.querySelector('.dropdown-content');
    dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
});
document.addEventListener('click', function() {
    document.querySelectorAll('.dropdown-content').forEach(dc => dc.style.display = 'none');
});

// ====================fin de l'implementation du dropdown==================