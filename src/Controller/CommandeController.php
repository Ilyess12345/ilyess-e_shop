<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\ProduitCommande;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function order(Request $request, ObjectManager $em, ProduitRepository $repo)
    {
    	// Build oder form    
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $commande->setDate(new \DateTime());
            $em->persist($commande);

            $session = new Session();
            $cart = $session->get('cart');

            foreach ($cart as $prd_id => $qty) {
                $ligneCommande = new ProduitCommande();
                $ligneCommande->setQte($qty);
                $prd = $repo->find($prd_id);
                $ligneCommande->setPrix($prd->getPrix());
                $ligneCommande->setProduit($prd);
                $ligneCommande->setCommande($commande);

                $em->persist($ligneCommande);
            }
            $em->flush();

            $num_cmd = $commande->getId();

            return $this->redirectToRoute('merci', [
                'order_id' => $num_cmd
            ]);
        }

        return $this->render("commande/commande.html.twig", [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/merci/{order_id}", name="merci")
     */
    public function success($order_id)
    {
        $session = new Session();
        $session->clear();

        return $this->render('commande/merci.html.twig', [
            'num_cmd' => $order_id
        ]);
    }


    /**
     * @Route("/admin/commande", name="admin_commande")
     */
    public function ordersAction(CommandeRepository $repo)
    {
        return $this->render('commande/index.html.twig', array(
            'commandes' => $repo->findAll(),
        ));
    }

}
