<?php
// src/Controller/SecurityController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class Access extends AbstractController
{
/**
* @Route("/access-denied", name="access_denied")
*/
public function accessDenied(): Response
{
$this->addFlash('error', 'Vous n\'avez pas les autorisations nécessaires pour accéder à cette page.');
return $this->redirectToRoute('#'); 
}
}