<?php

namespace App\Controller;

use App\Entity\Folk;
use App\Enum\AppGroups;
use App\Middlewares\CookieService;
use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class AuthController extends AbstractController
{
	public function __construct(
		private AuthService $authService,
		private SerializerInterface $serializer,
		private CookieService $cookieService
	) {
	}

	public function __invoke(#[CurrentUser] ?Folk $user): JsonResponse
	{
		if (!$user) {
			throw $this->createAccessDeniedException('Vous devez être connecté');
		}

		return $this->json($user, 200, [], ['groups' => [AppGroups::USER_READ]]);
	}

	#[Route('/api/register', name: 'register', methods: ['POST'])]
	public function register(Request $request): Response
	{
		$user = $this->serializer->deserialize($request->getContent(), Folk::class, 'json');
		$token = $this->authService->register($user);
		$cookie = $this->cookieService->generateCookie($token);
		$response = new JsonResponse(["message" => "User registered successfully", "token" => $token]);
		$response->headers->setCookie($cookie);
		return $response;
	}

	#[Route('api/logout', name: 'logout', methods: ['POST'])]
	public function logout(): Response
	{
		$cookie = $this->cookieService->deleteCookie();
		$response = new JsonResponse(["message" => "User logged out successfully"]);
		$response->headers->setCookie($cookie);
		return $response;
	}
}
