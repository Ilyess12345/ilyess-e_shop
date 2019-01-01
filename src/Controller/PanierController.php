<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{

    /**
     * @Route("/Panier", name="Panier")
     */
    function Panier(ProduitRepository $repo)
    {
        $session = new Session();
        $cart = $session->get('Panier');
        $products = array();

        $total_ht = 0;

          // Calcul du total HT, mnt TVA et total TTC
          // On ne doit pas laisser la vue faire le calcul
        if ($cart)
            foreach ($cart as $produit_id => $qty) {
            $prd = $repo->find($produit_id);
            $products[] = $prd;
            $total_ht += $prd->getPrix() * $qty;
        }

        $mnt_tva = $total_ht * 10 / 100;
        $total_ttc = $total_ht + $mnt_tva;

        return $this->render(
            "panier/showPanier.html.twig",
            [
                'products' => $products,
                'cart' => $cart,
                'total_ht' => $total_ht,
                'mnt_tva' => $mnt_tva,
                'total_ttc' => $total_ttc
            ]
        );
    }


    /**
     * @Route("supprimer/{id}", name="supprimer")
     */
    function SuppDeLaPanier($id)
    {
        $session = new Session();
        $cart = $session->get('Panier');
        unset($cart[$id]); // Remove item from row
        $session->set('Panier', $cart);
          
          // Retrouner au panier
        return $this->redirectToRoute('Panier');
    }


    /**
     * @Route("/ViderPanier" , name="Vider")
     */
    public function Vider()
    {
        $session = new Session();
        $session->clear();

        return $this->redirectToRoute('Panier');
    }


    public function nbproduit()
    {
        // récuprer le panier depuis la session et calculer le nb des prd
        $session = new Session();
        $cart = $session->get('Panier');
        $n = empty($cart) ? 0 : count($cart);
        // count($cart)
        return $this->render('panier/panier.html.twig', [
            'n' => $n
        ]);
    }

    /**
     * @Route("/ajouter/{id}", name="ajouter")
     */
    function AjouterAuPanier(Produit $prd)
    {
        $session = new Session();
        @$cart = $session->get('Panier');
        @$cart[$prd->getId()]++;
        $session->set('Panier', $cart);

        return $this->redirectToRoute('Panier');
    }



}
