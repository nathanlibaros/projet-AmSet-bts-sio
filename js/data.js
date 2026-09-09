/*
  Données de démonstration.
  Dans la version finale, ces tableaux viendront de l'API (fetch) :
  GET /api/sites, GET /api/competences, GET /api/salaries?site=&competences=
*/

const SITES = ["Paris", "Madrid", "Montréal", "Casablanca"];

/* Les libellés ne sont pas stockés ici : chaque compétence a un code,
   et la traduction se trouve dans js/i18n/<langue>.js sous "skill.<code>". */
const SKILLS = ["obj", "sys", "conc", "integ", "web"];

const EMPLOYEES = [
  {
    id: 1, civilite: "mme", nom: "Bernard", prenom: "Claire",
    email: "c.bernard@amset.com", telephone: "+33 1 44 12 08 91",
    adresse: "12 rue de Rivoli", codePostal: "75004", ville: "Paris",
    site: "Paris", competences: ["obj", "conc", "web"]
  },
  {
    id: 2, civilite: "m", nom: "Ortega", prenom: "Luis",
    email: "l.ortega@amset.com", telephone: "+34 91 320 44 17",
    adresse: "Calle Mayor 8", codePostal: "28013", ville: "Madrid",
    site: "Madrid", competences: ["sys", "integ"]
  },
  {
    id: 3, civilite: "mme", nom: "Tremblay", prenom: "Sophie",
    email: "s.tremblay@amset.com", telephone: "+1 514 555 0184",
    adresse: "430 rue Sherbrooke", codePostal: "H3A 1B7", ville: "Montréal",
    site: "Montréal", competences: ["web", "obj"]
  },
  {
    id: 4, civilite: "m", nom: "El Amrani", prenom: "Karim",
    email: "k.elamrani@amset.com", telephone: "+212 522 47 13 60",
    adresse: "25 boulevard d'Anfa", codePostal: "20250", ville: "Casablanca",
    site: "Casablanca", competences: ["conc", "integ", "sys", "obj"]
  },
  {
    id: 5, civilite: "m", nom: "Nowak", prenom: "Adrien",
    email: "a.nowak@amset.com", telephone: "+33 1 44 12 08 55",
    adresse: "3 avenue de la République", codePostal: "75011", ville: "Paris",
    site: "Paris", competences: ["sys"]
  },
  {
    id: 6, civilite: "mme", nom: "Diallo", prenom: "Fatou",
    email: "f.diallo@amset.com", telephone: "+34 91 320 78 02",
    adresse: "Gran Vía 41", codePostal: "28013", ville: "Madrid",
    site: "Madrid", competences: ["web", "integ", "conc"]
  }
];
