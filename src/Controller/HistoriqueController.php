<?php

namespace App\Controller;

use App\Entity\Statuts;
use App\Form\RetourType;
use App\Entity\Historique;
use App\Entity\Reparations;
use App\Form\HistoriqueType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\HistoriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/historique')]
final class HistoriqueController extends AbstractController
{
    #[Route(name: 'app_historique_index', methods: ['GET'])]
    public function index(HistoriqueRepository $historiqueRepository): Response
    {
        return $this->render('historique/index.html.twig', [
            'historiques' => $historiqueRepository->findAll(),
        ]);
    }

    #[Route('/retard', name: 'app_historique_retard', methods: ['GET'])]
    public function retard(HistoriqueRepository $historiqueRepository): Response
    {   
        $Nbretard = $historiqueRepository->countRetard();
        $Retard = $historiqueRepository->Retard();
        return $this->render('historique/retard.html.twig', [
            "NbRetard" => $Nbretard,
            "Retard" => $Retard
        ]);
    }

    #[Route('/new', name: 'app_historique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $historique = new Historique();
        $form = $this->createForm(HistoriqueType::class, $historique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($historique);
            $entityManager->flush();

            return $this->redirectToRoute('app_historique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('historique/new.html.twig', [
            'historique' => $historique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_historique_show', methods: ['GET'])]
    public function show(Historique $historique): Response
    {
        return $this->render('historique/show.html.twig', [
            'historique' => $historique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_historique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Historique $historique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HistoriqueType::class, $historique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_historique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('historique/edit.html.twig', [
            'historique' => $historique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/retour', name: 'app_historique_retour', methods: ['GET', 'POST'])]
    public function retour(Request $request, Historique $historique, EntityManagerInterface $entityManager): Response
    {

        if (!$historique) {
            throw $this->createNotFoundException('Historique non trouvé');
        }

        $form = $this->createForm(RetourType::class, $historique);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $etat = $form->get('etat')->getData();
            $produit = $historique->getProduit();
            $produit->setIdEtat($etat);
            if ($etat->getNom() == 'à réparer') {
                $reparation = new Reparations();
                $reparation->setProduit($produit);
                $reparation->setDateSignalement(new \DateTime());
                $status = $entityManager->getRepository(Statuts::class)->find(1); 
                if ($status) {
                    $reparation->setStatus($status); 
                    $entityManager->persist($reparation);
                }
            }

            $entityManager->persist($historique);
            $entityManager->flush();

        }
        return $this->render('historique/retour.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/{id}', name: 'app_historique_delete', methods: ['POST'])]
    public function delete(Request $request, Historique $historique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$historique->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($historique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_historique_index', [], Response::HTTP_SEE_OTHER);
    }

}
