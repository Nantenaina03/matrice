<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InterrController extends AbstractController
{
    #[Route('/interr', name: 'app_interr')]
    public function index(): Response
    {
        return $this->render('interr/index.html.twig', [
            'controller_name' => 'InterrController',
        ]);
    }
}
