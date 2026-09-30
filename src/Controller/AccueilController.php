<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    /**
     * Page d'accueil : renvoie vers la liste des salariés dans la langue par défaut.
     * Les anciennes adresses sans langue sont aussi redirigées.
     */
    #[Route('/', name: 'app_accueil', methods: ['GET'])]
    public function accueil(): Response
    {
        return $this->redirectToRoute('app_salarie_index', ['_locale' => $this->getParameter('kernel.default_locale')]);
    }

    #[Route('/salarie', methods: ['GET'])]
    public function ancienneListe(): Response
    {
        return $this->redirectToRoute('app_salarie_index', ['_locale' => $this->getParameter('kernel.default_locale')]);
    }

    #[Route('/recherche', methods: ['GET'])]
    public function ancienneRecherche(): Response
    {
        return $this->redirectToRoute('app_recherche', ['_locale' => $this->getParameter('kernel.default_locale')]);
    }
}
