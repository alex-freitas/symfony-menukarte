<?php

namespace App\Controller;

use App\Entity\Bestellung;
use App\Entity\Gericht;
use App\Repository\BestellungRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestellungController extends AbstractController
{
    #[Route('/bestellung', name: 'bestellung')]
    public function index(BestellungRepository $bestellungRepository): Response
    {
        $bestellungen = $bestellungRepository->findBy(['tisch' => 'tisch1']);

        return $this->render('bestellung/index.html.twig', 
            ['bestellungen' => $bestellungen]
        );
    }

    #[Route('/bestellen/{id}', name: 'bestellen')]
    public function order(Gericht $gericht, ManagerRegistry $doctrine): Response {        
        $bestellung = (new Bestellung())
            ->setTisch("tisch1")
            ->setName($gericht->getName())
            ->setBnummer($gericht->getId())
            ->setPreis($gericht->getPreis())
            ->setStatus("offen");
        
        $entityManage = $doctrine->getManager();
        $entityManage->persist($bestellung);
        $entityManage->flush();

        $nachricht = $bestellung->getName() . ' wurde zur Bestellung hinzugefügt';
        $this->addFlash('bestell', $nachricht);

        $responseRedirect = $this->redirect($this->generateUrl('menu'));
        return $responseRedirect;
    }
}
