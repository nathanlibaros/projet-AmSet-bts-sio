# Amset — maquette V1 (web)

Maquette statique de l'outil de gestion des salariés. Aucune dépendance, aucun
build : ouvrir `index.html` dans un navigateur suffit (ou `Live Server` dans VS Code).

## Arborescence

```
index.html          structure de la page
css/styles.css      styles
js/data.js          jeu de données de démonstration (remplacera l'appel API)
js/i18n.js          moteur de traduction
js/i18n/fr.js       dictionnaire français
js/i18n/en.js       dictionnaire anglais
js/app.js           état de l'écran, filtres, tri, fiche, formulaire
```

## Ce que couvre la maquette

- consultation de la liste des salariés, triable sur chaque colonne
- recherche par site et par une ou plusieurs compétences, sans rechargement
- consultation d'une fiche salarié
- formulaire de création d'une fiche (en mémoire uniquement)
- bascule français / anglais, mémorisée dans `localStorage`

## Ajouter une langue

1. copier `js/i18n/fr.js` en `js/i18n/es.js`, traduire les valeurs et remplacer
   `window.I18N.fr` par `window.I18N.es` ;
2. ajouter `<script src="js/i18n/es.js"></script>` dans `index.html` ;
3. ajouter un bouton `<button type="button" data-lang="es">ES</button>` dans la barre de langue.

Aucune chaîne n'est écrite en dur dans `app.js` : les libellés de compétences
sont eux aussi des clés de traduction (`skill.obj`, `skill.web`, ...), seuls les
codes sont stockés côté données.

## Ce qui reste à faire pour la version réelle

- remplacer `js/data.js` par des appels à l'API du framework retenu
- persistance en base (tables `salarie`, `competence`, `salarie_competence`, `site`)
- modification effective d'une fiche existante
- authentification et droits par service (RH / commercial)
