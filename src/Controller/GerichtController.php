<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Form\GericthType;
use App\Repository\GerichtRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gericht', name: 'gericht.')]
class GerichtController extends AbstractController
{ 
    #[Route('/', name: 'bearbeiten')]
    public function index(GerichtRepository $repository): Response
    {
        $gerichte = $repository->findAll();

        return $this->render('gericht/index.html.twig', [
            'gerichte' => $gerichte
        ]);
    }

    #[Route('/anlegen', name: 'anlegen')]
    public function anlegen(Request $request, ManagerRegistry $doctrine)
    {
        $gericht = new Gericht();
        $form = $this->createForm(GericthType::class, $gericht);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //$em = $this->getDoctrine()->getManager();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($gericht);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('gericht.bearbeiten'));
        }

        return $this->render('gericht/anlegen.html.twig', [
            'anlegenForm' => $form->createView()
        ]);
    }
    
    #[Route('/entfernen/{id}', name: 'entfernen')]
    public function entfernen($id, GerichtRepository $repository, ManagerRegistry $doctrine) 
    {
        $entityManager = $doctrine->getManager();
        $gericht = $repository->find($id);
        $entityManager->remove($gericht);
        $entityManager->flush();

        $this->addFlash('erfolg', 'Gericht wurde erfolgreich entfernt');    

        return $this->redirect($this->generateUrl('gericht.bearbeiten'));
    }    
}
