<?php

namespace App\Service;

use App\Entity\Folk;
use App\Repository\FolkRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthService
{
	public function __construct(
		private FolkRepository $folkRepository,
		private JWTTokenManagerInterface $jwtTokenManager
	) {
	}

	public function register(Folk $folk): string
	{
		$this->folkRepository->save($folk);
		return $this->jwtTokenManager->create($folk);
	}
}
