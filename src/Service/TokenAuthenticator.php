<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class TokenAuthenticator
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Récupère l'utilisateur depuis le token d'authentification dans le header "Authorization"
     */
    public function getUserFromRequest(Request $request): ?User
    {
        $token = $this->extractToken($request);
        if (!$token) {
            return null;
        }

        return $this->em->getRepository(User::class)->findOneBy(['token' => $token]);
    }

    /**
     * Récupère uniquement la valeur du token brut depuis le header
     */
    private function extractToken(Request $request): ?string
    {
        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader) {
            return null;
        }

        // Format attendu : Authorization: Bearer TOKEN
        if (str_starts_with($authHeader, 'Bearer ')) {
            return substr($authHeader, 7);
        }

        return $authHeader; // sinon on accepte un token brut
    }
}
