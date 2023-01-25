<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class FirstController extends AbstractController
{
    #[Route('/first/{name}', name: 'app_first')]
    public function index(Request $request, $name): Response
    {
        //search in database for users
        return $this->render('first/index.html.twig', [
            'name' =>$name,
            'lastname'=>'ketata',
            'path' => '       '
        ]);
    }

    #[Route('/template', name: 'template')]
    public function template(): Response
    {
        return $this->render('template.html.twig');
    }


    public function sayHello($name, $firstname): Response
    {
        return $this->render('hello.html.twig',
        ['name'=>$name, 'firstname'=>$firstname]);
    }

}
