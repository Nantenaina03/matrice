<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first/Mamisoa', name: 'first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'titre' => 'FirstController',
            'name' => 'Wendel',
            'firstname' => 'Mamisoa'
        ]);
    }
    
    #[Route('/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        return $this->render('first/hello.html.twig', [
            'nom' => $name,
            'prenom' => $firstname,
            'path' => '  ' 
        ]);
    }

    #[Route(
        '/multi/{entier1<\d+>}/{entier2<\d+>}', 
        name:'multi',
    )]
    public function mutliplication($entier1, $entier2){
        $resultat = $entier1 * $entier2;
        return new Response("$resultat");
    }
    
    #[Route('/date', name:'date')]
    public function screenDate() : Response {
        return $this->render('first/hello.html.twig');
    }
}