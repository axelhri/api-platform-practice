<?php

namespace App\Controller;

use App\Entity\Folk;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AuthController extends AbstractController {
    public function __construct(private AuthService $authService, private SerializerInterface $serializer)
    {

    }

    #[Route('/api/register', name: 'register', methods: ['POST'])]
    public function register(Request $request):Response {
        $user = $this->serializer->deserialize($request->getContent(), Folk::class, 'json');
        $token = $this->authService->register($user);
        return new JsonResponse(["message" => "utilisateur crée avec succèes" . $token], Response::HTTP_CREATED);
    }
}
