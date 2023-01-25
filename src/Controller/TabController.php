<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/users', name: 'app_tab')]
    public function index(): Response
    {
        $users=[['firstname'=>'youssef', 'name'=>'ketata', 'age'=>'22'],
            ['firstname'=>'ahmed', 'name'=>'ketata', 'age'=>'15'],
            ['firstname'=>'basma', 'name'=>'guoiaa', 'age'=>'21']
            ];
        return $this->render('users.html.twig', [
            'users' => $users
        ]);
    }
}
