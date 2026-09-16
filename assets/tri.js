/*
 * Tri des tableaux côté client (sans rechargement de la page).
 * Utilisation : <table data-sortable> et <th data-sort> sur les colonnes triables.
 */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('table[data-sortable]').forEach((table) => {
        const headers = table.querySelectorAll('th[data-sort]');

        headers.forEach((th) => {
            th.addEventListener('click', () => {
                const index = Array.from(th.parentNode.children).indexOf(th);
                const asc = th.dataset.dir !== 'asc';

                headers.forEach((h) => delete h.dataset.dir);
                th.dataset.dir = asc ? 'asc' : 'desc';

                const tbody = table.tBodies[0];
                const rows = Array.from(tbody.querySelectorAll('tr[data-row]'));

                rows.sort((a, b) => {
                    const va = a.children[index].textContent.trim();
                    const vb = b.children[index].textContent.trim();
                    return asc
                        ? va.localeCompare(vb, 'fr', { sensitivity: 'base' })
                        : vb.localeCompare(va, 'fr', { sensitivity: 'base' });
                });

                rows.forEach((row) => tbody.appendChild(row));
            });
        });
    });
});
