<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use App\Repository\ProduitRepository;
use App\Entity\Produit;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index(CategorieRepository $repo)
    {
        return $this->render('front/index.html.twig', [
            'categories' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="show_produits")
     */
    public function showProduits(Categorie $categorie, ProduitRepository $repo)
    {
        $produits = $repo->createQueryBuilder('p')
            ->innerJoin('p.categories', 'c')
            ->where('c.id = :cat')
            ->setParameter('cat', $categorie->getId())
            ->getQuery()->getResult();

        return $this->render('front/produits.html.twig', [
            'categorie' => $categorie,
            'produits' => $produits

        ]);
    }

    /**
     * @Route("/produit/{id}", name="show_produit")
     */
    public function showProduit(Produit $produit)
    {
        return $this->render('front/produit.html.twig', [
            'produit' => $produit
        ]);
    }



}
