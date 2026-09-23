/*
 * Page de recherche : à chaque changement de filtre (site ou compétence),
 * on redemande les résultats au serveur et on remplace le tableau,
 * sans recharger la page.
 */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#form-recherche');
    const zone = document.querySelector('#resultats');

    if (!form || !zone) {
        return;
    }

    const rafraichir = async () => {
        const params = new URLSearchParams(new FormData(form));

        try {
            const reponse = await fetch(form.dataset.url + '?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (!reponse.ok) {
                throw new Error('Erreur ' + reponse.status);
            }

            zone.innerHTML = await reponse.text();
            document.dispatchEvent(new Event('tableaux:maj'));

            // On garde les filtres dans l'adresse, pour pouvoir partager le lien.
            window.history.replaceState(null, '', params.toString() ? '?' + params : location.pathname);
        } catch (e) {
            zone.innerHTML = '<div class="tableau-conteneur"><p class="vide">Impossible de charger les résultats.</p></div>';
        }
    };

    form.addEventListener('change', rafraichir);
    // Le bouton "Réinitialiser" vide les champs après l'événement, d'où le délai.
    form.addEventListener('reset', () => setTimeout(rafraichir, 0));
    form.addEventListener('submit', (e) => e.preventDefault());
});
