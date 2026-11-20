<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailController extends AbstractController
{
    #[Route('/envoyer-email', name: 'app_envoyer_email')]
    public function envoyer(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('test@example.com')
            ->to('destinataire@example.com')
            ->subject('Mon premier email avec Symfony')
            ->text('Bonjour ! Ceci est un email envoyé depuis mon application Symfony.');

        $mailer->send($email);

        return new Response('Email envoyé avec succès !');
    }
}
