<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route("/",name:"todo")]
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        if(!$session->has(name:'todos')) {
            $todos = [
                'achat' => 'acheter clé usb',
                'cours' => 'Finalier mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash(type:'info', message:"La liste des todos viens d'être initialisé");
        }
        
        return $this->render('todo/index.html.twig');
    }
    
    #[Route(
        '/add/{name?test}/{content?Valeurs par defaut}', 
        name: 'todo.add'
    )]
    public function addTodo(Request $request, $name, $content){
        $session = $request->getSession();
        
        //verifier si j'ai un tableau de todo
        if($session->has('todos')) {
            
            $todos = $session->get('todos');
            //verifier si j'ai déjà un todo de meme name 
            if(isset($todos[$name])) {
                //si oui affiche l'erreur
                $this->addFlash(type:'error', message:"Le todos d'id $name éxiste déjà dans la liste");
            } else {
                //si non, on l'ajouter et on affiche un message de succès
                $todos[$name] = $content;
                $this->addFlash(type:'success', message:"Le todo d'id $name a été ajouter");
                $session->set('todos', $todos);
            }
        } else {
             
            $this->addFlash(type:'error', message:"La liste des todos n'est pas encore initialisé");
        }
        return $this->redirectToRoute('todo');
    }
    #[Route('/delete/{name}', name:'delete_todo')]
    public function deleteTodo(Request $request, $name) {
    
        $session = $request->getSession();
        //verifier si le todos existe dans la session
        if($session->has('todos')) {
            $todos = $session->get('todos');
            if(isset($todos[$name])) {
                unset($todos[$name]);
                $session->set('todos', $todos);
            } else {
                $this->addFlash(type: 'error', message:"L'id $name n'existe pas dans la liste");
            }
        } else {
            $this->addFlash(type:"error", message:"le todo n'existe pas");
        } 
        return $this->redirectToRoute('todo');
    } 
    #[Route('/update/{name}/{content}', name:"update_todo")]
    public function updateTodo(Request $request, $name, $content) {
        $session = $request->getSession();
        if($session->has('todos')) {
            $todos = $session->get('todos');
            if(isset($todos[$name])) {
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash(type: 'success', message: "Le todo d'id $name a été bien modifier");
            } else {
                $this->addFlash(type:"error", message:"L'id $name n'existe pas");
            }
        } else {
            $this->addFlash(type: "error", message:"La liste de todo n'a pas encore initialisé");
        }
        return $this->redirectToRoute('todo');
    } 
    
    #[Route('/rest', name:"rest_todo")]
    public function restTodo(Request $request) {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('todo');
    }
}