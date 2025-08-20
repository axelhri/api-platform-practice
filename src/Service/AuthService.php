<?php

namespace App\Service;

use App\Entity\Folk;
use App\Repository\FolkRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private FolkRepository $folkRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtTokenManager
    ) {
    }

    public function register(Folk $folk): string
    {
        $password = $this->passwordHasher->hashPassword($folk, $folk->getPassword());
        $folk->setPassword($password);
        $this->folkRepository->save($folk);
        return $this->jwtTokenManager->create($folk);
    }
}
