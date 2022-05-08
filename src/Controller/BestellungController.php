<?php

namespace App\Controller;

use App\Entity\Bestellung;
use App\Entity\Gericht;
use App\Repository\BestellungRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestellungController extends Controller
{
    private $doctrine;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->doctrine = $managerRegistry;
    }

    #[Route('/bestellung', name: 'bestellung')]
    public function index(BestellungRepository $bestellungRepository): Response
    {
        $bestellungen = $bestellungRepository->findBy(['tisch' => 'tisch1']);

        return $this->render('bestellung/index.html.twig', 
            ['bestellungen' => $bestellungen]
        );
    }

    #[Route('/bestellen/{id}', name: 'bestellen')]
    public function order(Gericht $gericht): Response {     
        
        $bestellung = (new Bestellung())
            ->setTisch("tisch1")
            ->setName($gericht->getName())
            ->setBnummer($gericht->getId())
            ->setPreis($gericht->getPreis())
            ->setStatus("offen");
        
        $entityManage = $this->doctrine->getManager();
        $entityManage->persist($bestellung);
        $entityManage->flush();

        $nachricht = $bestellung->getName() . ' wurde zur Bestellung hinzugefügt';
        $this->addFlash('bestell', $nachricht);

        $responseRedirect = $this->redirect($this->generateUrl('menu'));
        return $responseRedirect;
    }

    #[Route('/status/{id}/{status}', name: 'status')]
    public function status($id, $status): Response  {
        $em = $this->doctrine->getManager();
        
        /**
         * @var BestellungRepository
         */        
        $repository = $em->getRepository(Bestellung::class);
        
        $bestellung = $repository->find($id);    
        $bestellung->setStatus($status);

        $em->flush();

        $url = $this->generateUrl('bestellung');
        return $this->redirect($url);
    }

    #[Route('/loeschen/{id}', name: 'loeschen')]
    //public function remove($id, BestellungRepository $repository)
    public function remove(Bestellung $entity)
    {

        // $ent = $repository->findOneBy(['id' => $id]);

        // dump($ent);

        // $entityManager = $this->doctrine->getManager();
        // $entity = $repository->find($id);

        

        $entityManager = $this->doctrine->getManager();

        if ($entity) {
            $entityManager->remove($entity);
            $entityManager->flush();
        }
        
        return $this->redirect($this->generateUrl('bestellung'));
    }
}
