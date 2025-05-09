<?php

namespace App\Controller;

use App\Entity\EmotionTracker;
use App\Entity\User;
use App\Entity\SecondaryEmotions;
use App\Form\EmotionTrackerType;
use App\Repository\EmotionTrackerRepository;
use App\Repository\PrimaryEmotionsRepository;
use App\Repository\SecondaryEmotionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmotionsTrackerController extends AbstractController
{
    #[Route('/traqueur', name: 'emotions-tracker')]
    public function emotionsTracker(
        Request $request,
        EntityManagerInterface $em,
        PrimaryEmotionsRepository $primaryRepo
    ): Response {
        $userId = $request->getSession()->get('user_id');
        if (!$userId) {
            $this->addFlash('error', 'Veuillez vous connecter.');
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

        // Récupération des émotions groupées par émotion primaire
        $primaryEmotions = $primaryRepo->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $tracker->setUser($user);

            // Récupérer les IDs depuis la requête
            $emotionIds = $request->request->all('secondaryEmotions');
            if ($emotionIds && is_array($emotionIds)) {
                foreach ($emotionIds as $id) {
                    $emotion = $em->getRepository(SecondaryEmotions::class)->find($id);
                    if ($emotion) {
                        $tracker->addSecondaryEmotion($emotion);
                    }
                }
            }

            $em->persist($tracker);
            $em->flush();

            $this->addFlash('success', 'Émotion enregistrée avec succès.');
            return $this->redirectToRoute('emotions-tracker-list');
        }

        return $this->render('pages/emotions-tracker.html.twig', [
            'form' => $form->createView(),
            'primaryGroups' => $primaryEmotions, // utilisé dans le twig
        ]);
    }

    #[Route('/traqueurs', name: 'emotions-tracker-list')]
    public function emotionsTrackerList(
        Request $request,
        EmotionTrackerRepository $repo,
        SecondaryEmotionsRepository $secondaryRepo,
        EntityManagerInterface $em
    ): Response {
        $userId = $request->getSession()->get('user_id');
        if (!$userId) {
            $this->addFlash('error', 'Connectez-vous pour voir vos traqueurs.');
            return $this->redirectToRoute('app_login');
        }

        $user = $em->getRepository(User::class)->find($userId);
        $trackers = $repo->findBy(['user' => $user], ['id' => 'DESC']);
        $allEmotions = $secondaryRepo->findAll();

        return $this->render('pages/emotions-tracker-list.html.twig', [
            'trackers' => $trackers,
            'allEmotions' => $allEmotions,
        ]);
    }

    #[Route('/statistiques', name: 'emotions-stats')]
    public function emotionsStats(
        Request $request,
        EmotionTrackerRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $userId = $request->getSession()->get('user_id');
        if (!$userId) {
            $this->addFlash('error', 'Veuillez vous connecter pour accéder aux statistiques.');
            return $this->redirectToRoute('app_login');
        }

        $user = $em->getRepository(User::class)->find($userId);
        $trackers = $repo->findBy(['user' => $user]);

        return $this->render('pages/emotions-statistics.html.twig', [
            'trackers' => $trackers,
        ]);
    }
    #[Route('/traqueur/{id}/modifier', name: 'emotions-tracker-edit')]
    public function editEmotionTracker(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        PrimaryEmotionsRepository $primaryRepo
    ): Response {
        $tracker = $em->getRepository(EmotionTracker::class)->find($id);

        if (!$tracker || $tracker->getUser()?->getId() !== $request->getSession()->get('user_id')) {
            $this->addFlash('error', 'Traqueur non trouvé ou accès interdit.');
            return $this->redirectToRoute('emotions-tracker-list');
        }

        $form = $this->createForm(EmotionTrackerType::class, $tracker);
        $form->handleRequest($request);
        $primaryGroups = $primaryRepo->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            // Réinitialiser les émotions sélectionnées
            $tracker->getSecondaryEmotions()->clear();

            $emotionIds = $request->request->all('secondaryEmotions');
            if ($emotionIds && is_array($emotionIds)) {
                foreach ($emotionIds as $id) {
                    $emotion = $em->getRepository(SecondaryEmotions::class)->find($id);
                    if ($emotion) {
                        $tracker->addSecondaryEmotion($emotion);
                    }
                }
            }

            $em->flush();
            $this->addFlash('success', 'Traqueur mis à jour.');
            return $this->redirectToRoute('emotions-tracker-list');
        }

        return $this->render('pages/emotions-tracker.html.twig', [
            'form' => $form->createView(),
            'primaryGroups' => $primaryGroups,
            'editMode' => true,
        ]);
    }

    #[Route('/traqueur/{id}/supprimer', name: 'emotions-tracker-delete', methods: ['POST'])]
    public function deleteEmotionTracker(
        int $id,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $tracker = $em->getRepository(EmotionTracker::class)->find($id);

        if (!$tracker || $tracker->getUser()?->getId() !== $request->getSession()->get('user_id')) {
            $this->addFlash('error', 'Traqueur non trouvé ou accès interdit.');
            return $this->redirectToRoute('emotions-tracker-list');
        }

        $em->remove($tracker);
        $em->flush();

        $this->addFlash('success', 'Traqueur supprimé.');
        return $this->redirectToRoute('emotions-tracker-list');
    }

}
