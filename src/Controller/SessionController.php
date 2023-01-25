<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function mysql_xdevapi\getSession;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        $nbVisit=0;
        $session=$request->getSession();
        if($session->has('nbVisit')){
            $session->set('nbVisit',$session->get('nbVisit')+1);
        }
        else{
            $nbVisit=1;
            $session->set('nbVisit',$nbVisit);


        }
        return $this->render('first/second.html.twig');
    }
}
