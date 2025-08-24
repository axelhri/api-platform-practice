<?php

namespace App\Tests\Entity;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\FolkRepository;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Tests\Trait\CommonTrait;
use App\Tests\Trait\DataProvider\UserProviderTrait;

class FolkTest extends ApiTestCase
{
	use CommonTrait;
	use UserProviderTrait;

	public function setUp(): void
	{
		$this->setUpClient();
	}

	#[Test]
	public function visitorShouldNotListUsers(): void
	{
		$this->client->request(Request::METHOD_GET, 'api/folks');
		static::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
	}

	#[Test]
	public function folkShouldListUsers(): void
	{
		$users = static::getContainer()->get(FolkRepository::class)->findAll();
		$assert = [];

		foreach ($users as $user) {
			$assert[] = [
				'id' => $user->getId(),
				'username' => $user->getUsername(),
				'email' => $user->getEmail(),
			];
		}

		$this->createAuthenticatedClient(
			static::provideUser()
		);

		$this->client->request(Request::METHOD_GET, 'api/folks');

		static::assertResponseIsSuccessful();
		static::assertJsonContains($assert);
	}
}
