<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Reparations;
use App\Form\Reparations1Type;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReparationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/reparations')]
final class ReparationsController extends AbstractController
{
    #[Route(name: 'app_reparations_index', methods: ['GET'])]
    public function index(ReparationsRepository $reparationsRepository): Response
    {
        return $this->render('reparations/index.html.twig', [
            'reparations' => $reparationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reparations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reparation = new Reparations();
        $form = $this->createForm(Reparations1Type::class, $reparation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reparation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reparations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reparations/new.html.twig', [
            'reparation' => $reparation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reparations_show', methods: ['GET'])]
    public function show(Reparations $reparation): Response
    {
        return $this->render('reparations/show.html.twig', [
            'reparation' => $reparation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reparations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reparations $reparation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Reparations1Type::class, $reparation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($reparation->getStatus() && $reparation->getStatus()->getEtat() === 'fini') {
                $produit = $reparation->getProduit();
                if ($produit) {
                    $etatRepare = $entityManager->getRepository(Etat::class)->findOneBy(['nom' => 'bon état']);

                    $produit->setIdEtat($etatRepare);
                    $entityManager->persist($produit);
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_reparations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reparations/edit.html.twig', [
            'reparation' => $reparation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reparations_delete', methods: ['POST'])]
    public function delete(Request $request, Reparations $reparation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reparation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reparation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reparations_index', [], Response::HTTP_SEE_OTHER);
    }
}
