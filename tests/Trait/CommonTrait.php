<?php

declare(strict_types=1);

namespace App\Tests\Trait;

use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\Folk;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

trait CommonTrait
{
	protected Client $client;

	public function setUp(): void
	{
		$this->setUpClient();
	}

	protected function setUpClient(): void
	{
		$clientOptions = [
			'base_uri' => 'https://api.agorafolk.local',
			'headers' => [
				'Content-Type' => 'application/json; charset=utf-8',
				'Accept' => 'application/json',
			],
		];

		$this->client = static::createClient([], $clientOptions);
		$this->client->disableReboot();
	}

	protected function createAuthenticatedClient(Folk $user): void
	{
		$jwtTokenManager = static::getContainer()->get(JWTTokenManagerInterface::class);

		$clientOptions = [
			'base_uri' => 'https://api.agorafolk.local/',
			'auth_bearer' => $jwtTokenManager->create($user),
			'headers' => [
				'Content-Type' => 'application/json; charset=utf-8',
				'Accept' => 'application/json',
			],
		];

		$this->client = static::createClient([], $clientOptions);
		$this->client->disableReboot();
	}
}
