document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.trim().toLowerCase();
    const clientList = document.getElementById('ClientList');
    const rows = clientList.querySelectorAll('.client-item');

    rows.forEach(row => {
        // Concatène toutes les cellules de la ligne pour la recherche
        const rowText = row.textContent.trim().toLowerCase();
        if (rowText.includes(searchValue) || searchValue === "") {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});


// ========== bouton pour aboutir a la page permettant de passer une commande lorsqu'on clique sur un client regulier=========

document.querySelectorAll('.client-item').forEach(item => {
    item.addEventListener('click', function() {
        window.location.href = `../HTML/PasserCommandeFournisseur.html`; 
    });
});