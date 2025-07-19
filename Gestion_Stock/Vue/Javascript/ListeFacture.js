// Filter clients by name
document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.trim().toLowerCase();
    const clientCards = document.querySelectorAll('.client-card');
    clientCards.forEach(card => {
        const name = card.querySelector('.client-name').textContent.trim().toLowerCase();
        card.style.display = (name.includes(searchValue) || searchValue === "") ? "" : "none";
    });
});

// Gestion du déroulant factures
document.querySelectorAll('.toggle-factures').forEach(btn => {
    btn.addEventListener('click', function() {
        const card = this.closest('.client-card');
        card.classList.toggle('active');
        // Change le texte du bouton
        if(card.classList.contains('active')) {
            this.textContent = "Masquer factures ▲";
        } else {
            this.textContent = "Voir factures ▼";
        }
    });
});
