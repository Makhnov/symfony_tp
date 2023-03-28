<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'twig_accueil')]
    public function index(Request $request): Response
    {
        return $this->render('/accueil/index.html.twig');
    }
    #[Route('/control', name: 'twig_control')]
    public function control(Request $request): Response
    {
        return $this->render('/control/index.html.twig');
    }
}

?>