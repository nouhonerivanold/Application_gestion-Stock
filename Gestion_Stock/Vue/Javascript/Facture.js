// Mettre à jour le montant restant lorsque l'utilisateur saisit un montant perçu
document.getElementById('montant-percu').addEventListener('input', function () {
    const montantPercu = parseInt(document.getElementById('montant-percu').value) || 0; // Par défaut 0 si vide ou invalide
    const montantTotal = parseInt(document.getElementById('montant-total').value) || 0; // Par défaut 0 si vide ou invalide
    document.getElementById('montant-restant').value = montantTotal - montantPercu;
    let etat = "attente";
    if(montantPercu < montantTotal && montantPercu > 0) {
        etat = "partiel";
    }
    else if(montantPercu >= montantTotal) {
        etat = "payé";
    }
    document.getElementById('etat-facture').textContent = etat;
});

// Télécharger la facture en PDF
document.getElementById('downloadBtn').addEventListener('click', function () {
    const montantPercu = parseInt(document.getElementById('montant-percu').value) || 0;
    const montantTotal = parseInt(document.getElementById('montant-total').value) || 0;
    document.getElementById('montant-restant').value = montantTotal - montantPercu;

    var element = document.getElementById('factureConteneur');
    html2pdf().from(element).save('facture.pdf');
});