document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.trim().toLowerCase();
    const clientList = document.getElementById('FournisseurList');
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


// ========= pour gerer un fournisseur ===========

    // Ouvre le modal au clic sur "Ajouter Fournisseur"
document.querySelector('.Header button').addEventListener('click', function() {
  document.getElementById('modalClient').style.display = 'flex';
});

// Ferme le modal
document.getElementById('closeModalBtn').onclick = function() {
  document.getElementById('modalClient').style.display = 'none';
};


// ============= fin pour gerer un Fournisseur ===========