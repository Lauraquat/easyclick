<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Carte;

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
            'entrees' => $this->getDoctrine()->getRepository(Carte::class)->findBy(['Type' => 'Entrées']),
        ]);
    }


    /**
     * @Route("/plats", name="plats")
     */
    public function plats(): Response
    {
        return $this->render('plats.html.twig', [
            'titre' => 'EasyClick',
            'plats' => $this->getDoctrine()->getRepository(Carte::class)->findBy(['Type' => 'Plats']),

        ]);
    }


    /**
     * @Route("/desserts", name="desserts")
     */
    public function desserts(): Response
    {
        return $this->render('desserts.html.twig', [
            'titre' => 'EasyClick',
            'desserts' => $this->getDoctrine()->getRepository(Carte::class)->findBy(['Type' => 'Desserts']),

        ]);
    }


    /**
     * @Route("/boissons", name="boissons")
     */
    public function boissons(): Response
    {
        return $this->render('boissons.html.twig', [
            'titre' => 'EasyClick',
            'boissons' => $this->getDoctrine()->getRepository(Carte::class)->findBy(['Type' => 'Boissons']),
        ]);
    }


    /**
     * @Route("/ajouter/{id}", name="ajouter", defaults={"id":""})
     */
    public function ajouter(Request $request, SessionInterface $session, $id): Response
    {
        $cartIds = $session->get('panier', []);

        if (array_key_exists($id, $cartIds)) {
            // si le plat existait dans le panier, on y ajoute la quantité
            $cartIds[$id]['quantite'] += $request->get('quantite');
        } else {
            // sinon, on ajoute le plat au panier
            $cartIds[$id] = [
                'id' => $id,
                'quantite' => $request->get('quantite'),
            ];
        }
        $session->set('panier', $cartIds); // et on remet la variable en session

        if (!empty($referer = $request->headers->get('referer'))) {
            return $this->redirect($referer);
        } else {
            return $this->redirectToRoute('formules');
        }
    }


    /**
     * @Route("/retirer/{id}", name="retirer")
     */
    public function retirer(Request $request, SessionInterface $session, $id): Response
    {
        $cartIds = $session->get('panier', []);

        // on retrouve le bon plat pour retirer 1 quantité (sauf si c'est déjà 0)
        if (array_key_exists($id, $cartIds)) {
            $quantite = $cartIds[$id]['quantite'] - 1;

            if ($quantite == 0) {
                // si la quantité tombe à 0, on retire le plat du panier
                unset($cartIds[$id]);
            } else {
                $cartIds[$id]['quantite'] = $quantite;
            }
        }

        $session->set('panier', $cartIds); // et on remet la variable en session

        return $this->redirectToRoute('panier');
    }


    /**
     * @Route("/panier", name="panier")
     */
    public function panier(SessionInterface $session): Response
    {
        $panier = [];

        foreach ($session->get('panier', []) as $item) {
            $item['intitule'] = $this->getDoctrine()->getRepository(Carte::class)->find($item['id'])->getIntitule();
            $panier[] = $item;
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
        try {
            foreach ($session->get('panier', []) as $item) {
                // récupère le plat du panier et retire la quantité du stock
                $plat = $this->getDoctrine()->getRepository(Carte::class)->find($item['id']);

                $plat->destocke($item['quantite']);
            }

        } catch (\Exception $e) {
            // si un problème de quantité survient, on réaffiche le panier avec un message d'erreur
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('panier');
        }


        // tout s'est bien passé, on vide le panier, on met à jour la bdd et on renvoie vers la page de confirmation
        $session->set('panier', []);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('panier-valide.html.twig');
    }
}
