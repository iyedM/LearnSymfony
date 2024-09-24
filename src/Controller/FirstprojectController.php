<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FirstprojectController extends AbstractController
{
    #[Route('/firstproject', name: 'app_firstproject')]
    public function index(): Response
    {
        return $this->render('firstproject/index.html.twig', [
            'controller_name' => 'FirstprojectController',
        ]);
    }
}
