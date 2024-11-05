<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\EtatRepository;
use App\Repository\HistoriqueRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GestionController extends AbstractController
{
    #[Route('/gestion', name: 'app_gestion')]
    public function index(ProduitRepository $produitRepository, EtatRepository $etatRepository, HistoriqueRepository $historiqueRepository, CategorieRepository $categorieRepository): Response
    {
        $nbProduit = $produitRepository->count();

        $etatCasse = $etatRepository->findOneBy(["nom" => "hors d'usage"]);
        $nbProduitsCasses = $produitRepository->count(['id_etat' => $etatCasse]);

        $etatReparer = $etatRepository->findOneBy(["nom" => "à réparer"]);
        $nbProduitsRepar = $produitRepository->count(['id_etat' => $etatReparer]);

        $enPret = $historiqueRepository->count(["retour"=>0]);
        $retourné = $historiqueRepository->count(["retour"=>1]);

        $nbcat = $categorieRepository->count();

        return $this->render('gestion/index.html.twig', [
            'nbproduit' => $nbProduit,
            'nbproduithorsdusage' => $nbProduitsCasses,
            'nbproduitARepar' => $nbProduitsRepar,
            'nbPret' => $enPret,
            'nbRetour' => $retourné,
            'nbCat' => $nbcat,
            'nbRetour' => '',
        ]);
    }


}
