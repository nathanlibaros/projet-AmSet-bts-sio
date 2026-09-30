-- Données des langues et des traductions de compétences.
-- À lancer une fois après "php bin/console doctrine:migrations:migrate".

INSERT INTO langue (code_langue, nom_langue) VALUES
('fr', 'Français'),
('en', 'English')
ON CONFLICT (code_langue) DO NOTHING;

-- Traductions françaises : on reprend le libellé de référence
INSERT INTO competence_traduction (id_competence, code_langue, libelle)
SELECT c.id_competence, 'fr', c.libelle FROM competence c
ON CONFLICT (id_competence, code_langue) DO NOTHING;

-- Traductions anglaises
INSERT INTO competence_traduction (id_competence, code_langue, libelle) VALUES
((SELECT id_competence FROM competence WHERE libelle = 'Développement objet'),              'en', 'Object-oriented development'),
((SELECT id_competence FROM competence WHERE libelle = 'Administration système et réseau'), 'en', 'System and network administration'),
((SELECT id_competence FROM competence WHERE libelle = 'Conception d''application'),        'en', 'Application design'),
((SELECT id_competence FROM competence WHERE libelle = 'Intégration d''applications'),      'en', 'Application integration'),
((SELECT id_competence FROM competence WHERE libelle = 'Développement web'),                'en', 'Web development')
ON CONFLICT (id_competence, code_langue) DO NOTHING;
