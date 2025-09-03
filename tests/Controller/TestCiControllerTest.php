<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestCiControllerTest extends WebTestCase
{

	public function testHomePageLoadsCorrectly(): void
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/test/ci');

		$this->assertResponseIsSuccessful();
		$this->assertSelectorTextContains('h1', 'hello world');
	}
}
