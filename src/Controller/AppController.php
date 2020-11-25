<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/formules", name="formules")
     */
    public function formules(): Response
    {
        return $this->render('formules.html.twig', [
            'titre' => 'EasyClick',
        ]);
    }
        

    /**
     * @Route("/entrees", name="entrees")
     */
    public function entrees(): Response
    {
        return $this->render('entrees.html.twig', [
            'titre' => 'EasyClick',
        ]);
    }
       
    
    /**
     * @Route("/plats", name="plats")
     */
    public function plats(): Response
    {
        return $this->render('plats.html.twig', [
            'titre' => 'EasyClick',
        ]);
    }
        
    /**
     * @Route("/desserts", name="desserts")
     */
    public function desserts(): Response
    {
        return $this->render('desserts.html.twig', [
            'titre' => 'EasyClick',
        ]);
    }

    /**
     * @Route("/boissons", name="boissons")
     */
    public function boissons(): Response
    {
        return $this->render('boissons.html.twig', [
            'titre' => 'EasyClick',
        ]);
    }

    /**
     * @Route("/ajouter/{id}", name="ajouter")
     */
    public function ajouter(SessionInterface $session, $id): Response
    {
        $cartIds = $session->get('panier' /* nom du paramètre */, [] /* valeur par défaut */);
        $cartIds[] = $id; // on ajoute l'id du produit dans la variable
        $session->set('panier', $cartIds); // et on remet la variable en session

        
        return $this->redirectToRoute('formules'); 

/*         // TODO rediriger vers la page d'où on vient => $request inconnue)
        $referer = filter_var($request->headers->get('referer'), FILTER_SANITIZE_URL);
        return $this->redirect($referer); 
 */        
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function panier(SessionInterface $session): Response
    {
        $panier = [];

        foreach ($session->get('panier', []) as $id) {
            $panier[] = ['id' => $id];
        }

        return $this->render('panier.html.twig', [
            'panier' => $panier,
        ]); 
    }

    /**
     * @Route("/valider", name="valider")
     */
    public function valider(SessionInterface $session): Response
    {
        foreach ($session->get('panier', []) as $id) {
            //TODO retirer de la bdd (1 ligne = 1 quantité)
            //TODO + vider panier
        }

        return $this->render('panier-valide.html.twig'); 
    }
}
