<?php

namespace App\Controller;

use App\Entity\Proprietaire;
use App\Form\ProprietaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProprietaireController extends AbstractController
{
    /**
     * @Route("/proprietaire", name="app_proprietaire")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Proprietaire::class);
        $proprietaire = $repo->findALL();

        return $this->render('proprietaire/index.html.twig',[
            'proprietaires' => $proprietaire,
        ]);

    }

    /**
     * @Route("/proprietaire/ajouter", name="app_proprietaire_ajouter")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $proprietaire = new Proprietaire();

        $form = $this->createForm(ProprietaireType::class, $proprietaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($proprietaire);
            $em->flush();

            //retour a l'accueil
            return $this->redirectToRoute("app_Proprietaire");
        }
        return $this->render("proprietaire/ajouter.html.twig",[
            'formulaire' => $form->createView()

        ]);
    }
}
