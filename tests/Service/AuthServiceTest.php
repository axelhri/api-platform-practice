<?php

namespace App\Tests\Service;

use App\Entity\Folk;
use App\Repository\FolkRepository;
use App\Service\AuthService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
	private AuthService $authService;
	private MockObject $folkRepository;
	private MockObject $jwtTokenManager;

	protected function setUp(): void
	{
		$this->folkRepository = $this->createMock(FolkRepository::class);
		$this->jwtTokenManager = $this->createMock(JWTTokenManagerInterface::class);

		$this->authService = new AuthService(
			$this->folkRepository,
			$this->jwtTokenManager,
		);
	}

	#[Test]
    public function testRegister(): void
    {
		// Arrange
		$folk = new Folk();
		$folk->setUsername('test');
		$folk->setPassword('test');
		$folk->setEmail('d@d.com');

		$expectedToken = 'token123';

		$this->folkRepository
			->expects($this->once())
			->method('save')
			->with($folk);

		$this->jwtTokenManager
			->expects($this->once())
			->method('create')
			->with($folk)
			->willReturn($expectedToken);

		// Act
		$actualToken = $this->authService->register($folk);

		// Assert
		$this->assertEquals($expectedToken, $actualToken);
    }
}
