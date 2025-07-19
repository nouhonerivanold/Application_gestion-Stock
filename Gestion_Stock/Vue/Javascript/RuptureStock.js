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

