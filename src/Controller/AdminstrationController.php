<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;

class AdminstrationController extends AbstractController
{
    /**
     * @Route("/adminstration", name="adminstration")
     */
    public function index(CategorieRepository $repocat, ProduitRepository $repoPro, CommandeRepository $repoCommande)
    {
        return $this->render('adminstration/index.html.twig', [

            'nbP' => count($repoPro->findAll()),
            'nbC' => count($repocat->findAll()),
            'nbCommande' => count($repoCommande->findAll())
        ]);
    }
}
