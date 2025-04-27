<?php

namespace App\Controller;

use Doctrine\Tests\ORM\Proxy\AbstractClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(Request $request): Response
    {
        $session = $request->getSession()->get('user_id');
        return $this->render('pages/index.html.twig', [
            'session' => $session,
        ]);
    }




}