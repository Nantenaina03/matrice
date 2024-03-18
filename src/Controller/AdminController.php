<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[
    Route('/utilisateur'),
]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'user.list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        dump($role);
        $repository = $doctrine->getRepository(User::class);
        $users = $repository->findAll();
        return $this->render('admin/index.html.twig', ['users' => $users]);
    }

    //-------------SUPPRESSION----------------------
    #[
        Route('/delete/{id}', name: 'user.delete'),
        IsGranted('ROLE_ADMIN')
    ]
    public function deletePersonne(User $user = null, ManagerRegistry $doctrine): RedirectResponse
    {
        // Récupérer l'utilisateur
        if ($user) {
            // Si l'utilisateur existe => le supprimer et retourner un flashMessage de succés
            $manager = $doctrine->getManager();
            // Ajoute la fonction de suppression dans la transaction
            $manager->remove($user);
            // Exécuter la transacition
            $manager->flush();
            $this->addFlash('success', "La personne a été supprimé avec succès");
        } else {
            //Sinon  retourner un flashMessage d'erreur
            $this->addFlash('error', "Personne innexistante");
        }
        return $this->redirectToRoute('user.list');
    }

    //-------MODIFICATION-----------
    
    // #[Route('/update/{id}/{name}/{firstname}/{age}', name: 'user.update')]
    // public function updatePersonne(User $user = null, ManagerRegistry $doctrine, $username, $password) {
    //     //Vérifier que la personne à mettre à jour existe
    //     if ($user) {
    //         // Si la personne existe => mettre a jour notre personne + message de succes
    //         $user->setUsername($username);
    //         $user->setPassword($password);
    //         $manager = $doctrine->getManager();
    //         $manager->persist($user);

    //         $manager->flush();
    //         $this->addFlash('success', "La personne a été mis à jour avec succès");
    //     }  else {
    //         //Sinon  retourner un flashMessage d'erreur
    //         $this->addFlash('error', "Personne innexistante");
    //     }
    //     return $this->redirectToRoute('user.list');
    // }
}