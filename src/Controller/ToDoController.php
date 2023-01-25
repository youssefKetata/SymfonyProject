<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route("/todo")]
class ToDoController extends AbstractController
{
    /**
     * @Route("/", name="app_to_do")
     */
    public function indexAction(Request $request): Response
    {
        $session = $request->getSession();
        if(!$session->has('todo')){
            $todo = [
                'achat'=>'acheter cle usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'];
            $session->set('todo',$todo);
            $this->addFlash('info', 'todo array is initialized');
        }
            return $this->render('index.html.twig',);
    }

    #[Route('/add/{name<^[A-Za-z]+$>?default}/{content<^[A-Za-z]+$>?default}',
        name: 'todo.add')]
    public function addTodo(Request $request, $name, $content): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $session = $request->getSession();
        if($session->has('todo')){
            $todo = $session->get('todo');
            if(isset($todo[$name])){
                $this->addFlash('error', "$name already is in todo array");
            }
            else{
                $todo[$name] = $content;
                $session->set('todo',$todo);
                $this->addFlash('success',"$name is added to todo array");
            }

        }else{
            $this->addFlash('error', 'todo array is not initialized');

        }
        return $this->redirectToRoute("app_to_do");


    }

    #[Route('/update/{name}/{element}', name: 'todo.update')]
    public function updateToDo(Request $request, $name, $element): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $session = $request->getSession();
        if($session->has('todo')){
            $todo=$session->get('todo');
            if(!isset($todo[$name])){
                $this->addFlash('error',"can't update $name because it does not exist in update");
            }
            else {
                $todo[$name] = $element;
                $session->set('todo', $todo);
                $this->addFlash('success',"$name is updated");
            }
        }else{
            $this->addFlash('error',"todo array is not initialized");
        }
        return $this->redirectToRoute("app_to_do");
    }

    #[Route('/delete/{name}/{content}', name: 'todo.delete')]
    public function deleteToDo(Request $request, $name): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $session = $request->getSession();
        if($session->has('todo')){
            $todo=$session->get('todo');
            if(!isset($todo[$name])){
                $this->addFlash('error',"can't delete $name because it does not exist in update");
            }
            else {
                unset($todo[$name]);
                $session->set('todo', $todo);
                $this->addFlash('success',"$name is deleted");
            }
        }else{
            $this->addFlash('error',"can't update because todo array is not initialized");
        }
        return $this->redirectToRoute("app_to_do");
    }

    #[Route('/reset', name: 'todo.reset')]
    public function resetToDo(Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $session = $request->getSession();
        $session->remove('todo');
        return $this->redirectToRoute("app_to_do");
    }

}
