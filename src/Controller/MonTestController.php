<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonTestController extends AbstractController
{
    #[Route('/mon/test', name: 'app_mon_test')]
    public function index(): Response
    {
        return $this->render('mon_test/index.html.twig', [
            'controller_name' => 'MonTestController',
        ]);
    }
}
