<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\InformationsRessources;
use App\Form\InformationsFormType;
use App\Repository\EmergencyInformationsRepository;
use App\Repository\InformationsRessourcesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class InformationsController extends AbstractController
{
    #[Route('/informations', name: 'information_index')]
    public function index(
        Request $request,
        EmergencyInformationsRepository $urgRepo,
        InformationsRessourcesRepository $resRepo
    ): Response {
        $emergencies = $urgRepo->findAll();
        $resources   = $resRepo->findAll();
        $userRole = $request->getSession()->get('user_role');

        return $this->render('pages/informations.html.twig', [
            'emergencies' => $emergencies,
            'resources'   => $resources,
            'user_role'   => $userRole,
        ]);
    }

    #[Route('/informations/ressource/ajouter', name: 'information_resource_new')]
    public function newResource(Request $request, EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        $userId = $session->get('user_id');

        if (!$userId) {
            $this->addFlash('error', 'Vous devez être connecté.');
            return $this->redirectToRoute('app_login');
        }

        $user = $em->getRepository(User::class)->find($userId);
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable.');
            return $this->redirectToRoute('app_login');
        }

        $resource = new InformationsRessources();
        $form = $this->createForm(InformationsFormType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resource->setAuthor($user);
            $em->persist($resource);
            $em->flush();

            $this->addFlash('success', 'Ressource ajoutée avec succès.');
            return $this->redirectToRoute('information_index');
        }

        return $this->render('pages/new_resource.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/informations/ressource/modifier/{id}', name: 'information_resource_edit')]
    public function editResource(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $session = $request->getSession();
        $userId = $session->get('user_id');

        if (!$userId) {
            $this->addFlash('error', 'Vous devez être connecté.');
            return $this->redirectToRoute('app_login');
        }

        $resource = $em->getRepository(InformationsRessources::class)->find($id);
        if (!$resource || $resource->getAuthor()?->getId() !== $userId) {
            $this->addFlash('error', 'Accès interdit.');
            return $this->redirectToRoute('information_index');
        }

        $form = $this->createForm(InformationsFormType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Ressource modifiée.');
            return $this->redirectToRoute('information_index');
        }

        return $this->render('pages/edit_resource.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    #[Route('/informations/urgence/{id}', name: 'information_emergency_show', requirements: ['id' => '\d+'])]
    public function showEmergency(
        int $id,
        EmergencyInformationsRepository $urgRepo
    ): Response {
        $item = $urgRepo->find($id);
        if (!$item) {
            throw $this->createNotFoundException('Information d\'urgence non trouvée.');
        }

        return $this->render('pages/information_detail.html.twig', [
            'item'       => $item,
            'back_route' => 'information_index',
        ]);
    }

    #[Route('/informations/ressource/{id}', name: 'information_resource_show', requirements: ['id' => '\d+'])]
    public function showResource(
        int $id,
        InformationsRessourcesRepository $resRepo
    ): Response {
        $item = $resRepo->find($id);
        if (!$item) {
            throw $this->createNotFoundException('Ressource non trouvée.');
        }

        return $this->render('pages/information_detail.html.twig', [
            'item'       => $item,
            'back_route' => 'information_index',
        ]);
    }
}
