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


// ========== bouton pour aboutir a la page permettant de passer une commande=========



// ========== bouton pour aboutir a la page permettant de passer une commande lorsqu'on clique sur un client regulier=========

document.querySelectorAll('.client-item').forEach(item => {
    item.addEventListener('click', function(event) {
        const $element = event.target.closest('.client-item');
        const nom = $element.querySelector('.last-name').textContent.trim();
        const prenom = $element.querySelector('.first-name').textContent.trim();
        const phone = $element.querySelector('.phone-number').textContent.trim();
        const ville = $element.querySelector('.ville').textContent.trim();
        const idClient = $element.getAttribute('data-id');

        fetch(`../../Controleur/commande_clientRegulier.php`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Réponse du serveur :', data);
            if (data.success) {
                const produits = encodeURIComponent(JSON.stringify(data.produits));
                // console.log(produits);
                window.location.href = `../HTML/PasserCommande.php?nom=${encodeURIComponent(nom)}&prenom=${encodeURIComponent(prenom)}&phone=${encodeURIComponent(phone)}&adresse=${encodeURIComponent(ville)}&produits=${produits}&idClient=${idClient}`; 
            }
            else{
                console.log('Erreur lors de la récupération des produits :');
            }
        })
        .catch(error => {
            console.log('Erreur lors de l\'envoi de la commande :', error);
        });
    });
});