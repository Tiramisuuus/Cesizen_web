<?php

namespace App\Controller;

use App\Entity\EmotionTracker;
use App\Entity\User;
use App\Form\EmotionTrackerType;
use App\Repository\EmotionTrackerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmotionsTrackerController extends AbstractController
{
    /**
     * Route for the emotions tracker
     * Create a form with all secondary emotions (checkboxes) and a slider for score.
     * On form submit: calculate the score and persist the EmotionTracker.
     */
    #[Route('/traqueur', name: 'emotions-tracker')]
    public function emotionsTracker(Request $request, EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        $userId = $session->get('user_id');

        if (!$userId) {
            $this->addFlash('error', 'Veuillez vous connecter pour accéder au traqueur.');
            return $this->redirectToRoute('app_login');
        }

        $user = $em->getRepository(User::class)->find($userId);
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable.');
            return $this->redirectToRoute('app_login');
        }

        $tracker = new EmotionTracker();
        $form = $this->createForm(EmotionTrackerType::class, $tracker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tracker->setUser($user);
            $em->persist($tracker);
            $em->flush();

            $this->addFlash('success', 'Émotion enregistrée avec succès.');
            return $this->redirectToRoute('emotions-tracker-list');
        }

        return $this->render('pages/emotions-tracker.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Shows the list of all emotions trackers linked to the user in session.
     */
    #[Route('/traqueurs', name: 'emotions-tracker-list')]
    public function emotionsTrackerList(Request $request, EmotionTrackerRepository $repo, EntityManagerInterface $em): Response
    {
        $userId = $request->getSession()->get('user_id');
        if (!$userId) {
            $this->addFlash('error', 'Connectez-vous pour voir vos traqueurs.');
            return $this->redirectToRoute('app_login');
        }

        $user = $em->getRepository(User::class)->find($userId);
        $trackers = $repo->findBy(['user' => $user]);

        return $this->render('pages/emotions-tracker-list.html.twig', [
            'trackers' => $trackers,
        ]);
    }

    /**
     * Page for emotions statistics
     */
    #[Route('/statistiques', name: 'emotions-stats')]
    public function emotionsStats(Request $request, EmotionTrackerRepository $repo, EntityManagerInterface $em): Response
    {
        $userId = $request->getSession()->get('user_id');
        if (!$userId) {
            $this->addFlash('error', 'Veuillez vous connecter pour accéder aux statistiques.');
            return $this->redirectToRoute('app_login');
        }

        $user = $em->getRepository(User::class)->find($userId);
        $trackers = $repo->findBy(['user' => $user]);

        // Stats à traiter dans le template ou service
        return $this->render('pages/emotions-statistics.html.twig', [
            'trackers' => $trackers,
        ]);
    }
}
