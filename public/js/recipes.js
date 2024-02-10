
// Fonction pour rafraîchir la page
function rafraichirPage() {
    window.location.reload();
}
function toggleIframe() {
    var iframe = document.getElementById('myIframe');
    // Vérifie si l'iframe est caché
    if (iframe.classList.contains('hidden')) {
        // Affiche l'iframe
        iframe.classList.remove('hidden');
    } else {
        // Cache l'iframe
        iframe.classList.add('hidden');
    }
}