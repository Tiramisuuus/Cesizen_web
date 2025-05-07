<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/profile', name: 'app_profile')]
    public function profile(Request $request, UserRepository $userRepo): Response
    {
        // Vérifie la présence d'un user_id en session
        $userId = $request->getSession()->get('user_id');
        if (!$userId) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à votre profil.');
            return $this->redirectToRoute('app_login');
        }

        // Récupère l'utilisateur
        $user = $userRepo->find($userId);
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('pages/profile.html.twig', [
            'user' => $user,
        ]);
    }
}