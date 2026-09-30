<?php

namespace App\Controller;

use App\Repository\CompetenceRepository;
use App\Repository\SalarieRepository;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale}/recherche', requirements: ['_locale' => 'fr|en'])]
class RechercheController extends AbstractController
{
    /**
     * Page de recherche : formulaire de filtres + première liste de résultats.
     */
    #[Route('', name: 'app_recherche', methods: ['GET'])]
    public function index(
        Request $request,
        SalarieRepository $salarieRepository,
        SiteRepository $siteRepository,
        CompetenceRepository $competenceRepository,
    ): Response {
        [$siteId, $competenceIds] = $this->criteres($request);

        return $this->render('recherche/index.html.twig', [
            'sites' => $siteRepository->findBy([], ['nom' => 'ASC']),
            'competences' => $competenceRepository->findBy([], ['libelle' => 'ASC']),
            'site_choisi' => $siteId,
            'competences_choisies' => $competenceIds,
            'salaries' => $salarieRepository->rechercher($siteId, $competenceIds),
        ]);
    }

    /**
     * Résultats seuls, appelés en AJAX à chaque changement de filtre
     * (pas de rechargement de la page).
     */
    #[Route('/resultats', name: 'app_recherche_resultats', methods: ['GET'])]
    public function resultats(Request $request, SalarieRepository $salarieRepository): Response
    {
        [$siteId, $competenceIds] = $this->criteres($request);

        return $this->render('recherche/_resultats.html.twig', [
            'salaries' => $salarieRepository->rechercher($siteId, $competenceIds),
        ]);
    }

    /**
     * Lit les critères envoyés dans l'URL : ?site=1&competences[]=2&competences[]=5
     *
     * @return array{0: int|null, 1: int[]}
     */
    private function criteres(Request $request): array
    {
        // On lit les valeurs en texte : le champ "Tous les sites" envoie une valeur vide.
        $siteId = (int) $request->query->get('site', '') ?: null;

        $competenceIds = array_values(array_filter(array_map(
            static fn ($valeur) => (int) $valeur,
            (array) $request->query->all('competences')
        )));

        return [$siteId, $competenceIds];
    }
}
