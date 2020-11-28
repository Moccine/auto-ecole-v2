<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // votre url http://127.0.0.1:8000/

        return $this->render('/driveon-light/hello.html.twig');
    }
}
