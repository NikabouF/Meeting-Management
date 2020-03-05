<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReunionController extends AbstractController
{
    /**
     * @Route("/reunion", name="reunion")
     */
    public function index()
    {
        return $this->render('reunion/index.html.twig', [
            'controller_name' => 'ReunionController',
        ]);
    }
}
