<?php

namespace App\Tests\Service;

use App\Entity\Folk;
use App\Repository\FolkRepository;
use App\Service\AuthService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthServiceTest extends TestCase
{

	private FolkRepository $folkRepository;
	private UserPasswordHasherInterface $passwordHasher;
	private JWTTokenManagerInterface $jwtTokenManager;
	private AuthService $authService;

	protected function setUp(): void
	{
		$this->folkRepository = $this->createMock(FolkRepository::class);
		$this->passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
		$this->jwtTokenManager = $this->createMock(JWTTokenManagerInterface::class);

		$this->authService = new AuthService(
			$this->folkRepository,
			$this->passwordHasher,
			$this->jwtTokenManager
		);
	}

	public function testRegisterHashesPasswordAndReturnsJwt(): void
	{
		// Arrange
		$folk = new Folk();
		$folk->setPassword('password');

		$this->passwordHasher
			->expects($this->once())
			->method('hashPassword')
			->with($folk, 'password')
			->willReturn('hashedPassword');

		$this->folkRepository
			->expects($this->once())
			->method('save')
			->with($this->callback(fn (Folk $folk) => $folk->getPassword() === 'hashedPassword'));

		$this->jwtTokenManager
			->expects($this->once())
			->method('create')
			->with($folk)
			->willReturn('token');

		// Act
		$token = $this->authService->register($folk);

		// Assert
		$this->assertSame('token', $token);
		$this->assertSame('hashedPassword', $folk->getPassword());
	}
}
