<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use App\Form\RegisterFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChangePasswordFormType;


class SecurityController extends AbstractController
{
    public function __construct(
        private UserRepository               $userRepository,
        private UserPasswordHasherInterface  $hasher,
        private EntityManagerInterface       $em
    ) {}

    #[Route('/profile/change-password', name: 'app_change_password')]
    public function changePassword(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em,
        UserRepository $userRepository
    ): Response {
        // Récupère l'ID en session
        $session = $request->getSession();
        $userId  = $session->get('user_id');
        if (!$userId) {
            $this->addFlash('error', 'Vous devez être connecté pour modifier votre mot de passe.');
            return $this->redirectToRoute('app_login');
        }

        // Charge manuellement l'utilisateur
        $user = $userRepository->find($userId);
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable.');
            return $this->redirectToRoute('app_login');
        }

        // Crée et traite le formulaire
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie le mot de passe actuel
            $current = $form->get('currentPassword')->getData();
            if (!$passwordHasher->isPasswordValid($user, $current)) {
                $form->get('currentPassword')
                    ->addError(new FormError('Mot de passe actuel incorrect.'));
            } else {
                // Récupère et hash le nouveau mot de passe
                $newPwd = $form->get('newPassword')->getData();
                $hashed = $passwordHasher->hashPassword($user, $newPwd);
                $user->setPassword($hashed);

                // Sauvegarde en base
                $em->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été modifié.');
                return $this->redirectToRoute('home');
            }
        }

        return $this->render('pages/change_password.html.twig', [
            'changePasswordForm' => $form->createView(),
        ]);
    }
    /**
     * Login manuel : cherche l’utilisateur, vérifie le mot de passe,
     * stocke l’ID en session, flash et redirection.
     */
    #[Route('/login', name: 'app_login')]
    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Récupère email/password depuis le form
            $data     = $form->getData();
            $email    = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            // Cherche l’utilisateur
            $user = $this->userRepository->findOneBy(['email' => $email]);
            if (!$user) {
                $this->addFlash('error', 'Adresse email inconnue.');
                return $this->redirectToRoute('app_login');
            }

            // Vérifie le mot de passe
            if (!$this->hasher->isPasswordValid($user, $password)) {
                $this->addFlash('error', 'Mot de passe incorrect.');
                return $this->redirectToRoute('app_login');
            }

            // Succès : on met l’ID en session
            $request->getSession()->set('user_id', $user->getId());
            $request->getSession()->set('user_role', $user->getRole());
            $this->addFlash('success', 'Connexion réussie !');

            // Redirige vers la home (ou dashboard)
            return $this->redirectToRoute('home');
        }

        return $this->render('pages/login.html.twig', [
            'loginForm' => $form->createView(),
        ]);
    }

    /**
     * Logout manuel : invalide la session puis renvoie sur le login avec un flash.
     */
    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request): Response
    {
        $request->getSession()->set('user_id', null);
        $request->getSession()->set('user_role', null);
        $this->addFlash('success', 'Vous avez été déconnecté.');
        return $this->redirectToRoute('home');
    }

    /**
     * Registration manuel : construit l’entité User, hash le mot de passe,
     * persiste, flash et redirection.
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Validation basique du formulaire
            if (!$form->isValid()) {
                $this->addFlash('error', 'Le formulaire comporte des erreurs.');
            } else {
                // Récupère les deux mots de passe (l’un mappé, l’autre non)
                $raw     = $form->get('password')->getData();       // champ mappé
                $confirm = $form->get('plainPassword')->getData();  // champ non mappé

                // Vérification de la confirmation
                if ($raw !== $confirm) {
                    $form->addError(new FormError('Les mots de passe ne correspondent pas.'));
                    $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                } else {
                    // Hash + initialisation des champs
                    $hashed = $this->hasher->hashPassword($user, $raw);
                    $user->setPassword($hashed)
                        ->setCreatedAt(new \DateTimeImmutable())
                        ->setIsActive(true)
                        ->setRole('ROLE_USER');

                    // Persiste en base
                    $this->em->persist($user);
                    $this->em->flush();

                    $this->addFlash('success', 'Votre compte a bien été créé.');

                    // Redirige vers la home (ou où vous voulez)
                    return $this->redirectToRoute('home');
                }
            }
        }

        return $this->render('pages/register.html.twig', [
            'registerForm' => $form->createView(),
        ]);

    }
}
