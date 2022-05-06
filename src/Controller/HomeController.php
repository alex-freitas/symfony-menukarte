<?php

namespace App\Controller;

use App\Repository\GerichtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    #[Route('/', name: 'home')]
    public function index(GerichtRepository $gerichtRepository): Response
    {        
        $gerichte = $gerichtRepository->findAll();

        $zufall = array_rand($gerichte, 2);

        $gerichteZufall = [
            $gerichte[$zufall[0]], 
            $gerichte[$zufall[1]],
        ];

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'gerichte' => $gerichteZufall,
        ]);
    }
}
