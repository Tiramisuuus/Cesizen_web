<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\InformationsRessources;
use App\Entity\EmergencyInformations;
use App\Entity\SecondaryEmotions;
use App\Form\UserFormType;
use App\Form\InformationsRessourcesType;
use App\Form\EmergencyInformationsType;
use App\Form\SecondaryEmotionsType;
use App\Repository\UserRepository;
use App\Repository\InformationsRessourcesRepository;
use App\Repository\EmergencyInformationsRepository;
use App\Repository\SecondaryEmotionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\FormError;

#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em
    ) {}

    #[Route('/users', name: 'admin_users_index')]
    public function listUsers(Request $request): Response
    {
        $session = $request->getSession();
        $userId = $session->get('user_id');

        if (!$userId) {
            $this->addFlash('error', 'Accès refusé. Connectez-vous.');
            return $this->redirectToRoute('app_login');
        }

        $user = $this->userRepository->find($userId);
        if (!$user || $user->getRole() !== 'ROLE_ADMIN') {
            $this->addFlash('error', 'Accès réservé aux administrateurs.');
            return $this->redirectToRoute('home');
        }

        $users = $this->userRepository->findAll();

        return $this->render('pages/bo-admin.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/users/new', name: 'admin_users_new')]
    public function newUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('error', 'Le formulaire contient des erreurs.');
            } else {
                $plainPassword = $form->get('password')->getData();

                if (!$plainPassword || strlen($plainPassword) < 6) {
                    $form->addError(new FormError('Le mot de passe doit contenir au moins 6 caractères.'));
                    $this->addFlash('error', 'Mot de passe trop court.');
                } else {
                    $hashedPassword = $hasher->hashPassword($user, $plainPassword);
                    $user->setPassword($hashedPassword);
                    $user->setCreatedAt(new \DateTimeImmutable());

                    $em->persist($user);
                    $em->flush();

                    $this->addFlash('success', 'Nouvel utilisateur créé avec succès.');
                    return $this->redirectToRoute('admin_users_index');
                }
            }
        }

        return $this->render('pages/new-user.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/users/{id}/edit', name: 'admin_users_edit')]
    public function editUser(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Utilisateur mis à jour.');
            return $this->redirectToRoute('admin_users_index');
        }
        return $this->render('pages/edit-user.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/users/{id}/toggle', name: 'admin_users_toggle', methods: ['POST'])]
    public function toggleUser(User $user, EntityManagerInterface $em): Response
    {
        $user->setIsActive(!$user->isActive());
        $em->flush();
        return $this->redirectToRoute('admin_users_index');
    }

    #[Route('/users/{id}/delete', name: 'admin_users_delete', methods: ['POST'])]
    public function deleteUser(Request $request, int $id, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $user = $userRepository->find($id);
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable.');
            return $this->redirectToRoute('admin_users_index');
        }

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'Utilisateur supprimé.');
        return $this->redirectToRoute('admin_users_index');
    }

    #[Route('/emotions', name: 'admin_emotions_index')]
    public function emotionsIndex(SecondaryEmotionsRepository $repo, Request $request): Response
    {
        $session = $request->getSession();
        $userId = $session->get('user_id');

        if (!$userId || ($this->userRepository->find($userId)?->getRole() !== 'ROLE_ADMIN')) {
            $this->addFlash('error', 'Accès réservé aux administrateurs.');
            return $this->redirectToRoute('home');
        }

        $emotions = $repo->findAll();

        return $this->render('pages/bo-admin-emotions.html.twig', [
            'emotions' => $emotions,
        ]);
    }

    #[Route('/emotions/{id}/edit', name: 'admin_emotions_edit')]
    public function editEmotion(SecondaryEmotions $emotion, Request $request): Response
    {
        $form = $this->createForm(SecondaryEmotionsType::class, $emotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Émotion modifiée avec succès.');
            return $this->redirectToRoute('admin_emotions_index');
        }

        return $this->render('pages/edit-emotion.html.twig', [
            'form' => $form->createView(),
            'emotion' => $emotion,
        ]);
    }

    #[Route('/emotions/{id}/delete', name: 'admin_emotions_delete', methods: ['POST'])]
    public function deleteEmotion(SecondaryEmotions $emotion): Response
    {
        $this->em->remove($emotion);
        $this->em->flush();

        $this->addFlash('success', 'Émotion supprimée.');
        return $this->redirectToRoute('admin_emotions_index');
    }
    #[Route('/emotions/new', name: 'admin_emotions_new')]
    public function newEmotion(Request $request): Response
    {
        // Vérification admin
        $session = $request->getSession();
        $userId = $session->get('user_id');
        $user = $this->userRepository->find($userId);
        if (!$user || $user->getRole() !== 'ROLE_ADMIN') {
            $this->addFlash('error', 'Accès réservé aux administrateurs.');
            return $this->redirectToRoute('home');
        }

        $emotion = new SecondaryEmotions();
        $form = $this->createForm(SecondaryEmotionsType::class, $emotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($emotion);
            $this->em->flush();
            $this->addFlash('success', 'Nouvelle émotion ajoutée.');
            return $this->redirectToRoute('admin_emotions_index');
        }

        return $this->render('pages/new-secondary-emotion.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
