<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    #[Route('/mail', name: 'mail')]
    public function send(MailerInterface $mailer): Response
    {
        $email = new TemplatedEmail();

        $email
            ->htmlTemplate('mailer/mail.html.twig')
            ->from('tisch@menukarte.wip')
            ->to('alex.freitas.dev@gmail.com')
            ->subject('Bestellung')
            ->context(['text' => 'Lorem Ipsum']);
                        
        $mailer->send($email);    

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
}
