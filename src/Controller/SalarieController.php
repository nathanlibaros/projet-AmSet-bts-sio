<?php

namespace App\Controller;

use App\Entity\Salarie;
use App\Form\SalarieType;
use App\Repository\SalarieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale}/salarie', requirements: ['_locale' => 'fr|en'])]
final class SalarieController extends AbstractController
{
    #[Route(name: 'app_salarie_index', methods: ['GET'])]
    public function index(SalarieRepository $salarieRepository): Response
    {
        return $this->render('salarie/index.html.twig', [
            'salaries' => $salarieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_salarie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salarie = new Salarie();
        $form = $this->createForm(SalarieType::class, $salarie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salarie);
            $entityManager->flush();

            return $this->redirectToRoute('app_salarie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salarie/new.html.twig', [
            'salarie' => $salarie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salarie_show', methods: ['GET'])]
    public function show(Salarie $salarie): Response
    {
        return $this->render('salarie/show.html.twig', [
            'salarie' => $salarie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_salarie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Salarie $salarie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SalarieType::class, $salarie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_salarie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salarie/edit.html.twig', [
            'salarie' => $salarie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salarie_delete', methods: ['POST'])]
    public function delete(Request $request, Salarie $salarie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salarie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($salarie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_salarie_index', [], Response::HTTP_SEE_OTHER);
    }
}
