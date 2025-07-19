document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.trim().toLowerCase();
    const clientList = document.getElementById('productList');
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

// // ========= pour gerer une unite ===========
    document.querySelector('.Header button').addEventListener('click', function() {
    document.getElementById('modalClient').style.display = 'flex';
    });

    // Ferme le modal
    document.getElementById('closeunite').onclick = function() {
    document.getElementById('modalClient').style.display = 'none';
    };

// ========= fin pour gerer une unite ===========

// ========= fin pour gerer une unite ===========

    // Ouvre le modal au clic sur n'importe quel bouton "Fractionner"
document.querySelectorAll('.client-item button').forEach(function(btn) {
    btn.addEventListener('click', function(event) {
        document.getElementById('Fractionner').style.display = 'flex';
        const idProduit = this.getAttribute('data-id');
        document.getElementById('idproduitFraction').value = idProduit;
    });
});

// Ferme le modal
document.getElementById('closeModalBtn').onclick = function() {
    document.getElementById('Fractionner').style.display = 'none';
};


// ============= fin pour gerer le fractionnement ===========