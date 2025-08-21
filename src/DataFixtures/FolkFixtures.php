<?php

namespace App\DataFixtures;

use App\Entity\Folk;
use App\Enum\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class FolkFixtures extends Fixture implements FixtureGroupInterface
{
	/**
	 * @var array<array< string, string|string[]>>
	 */
	public static array $fixtures = [
		[
			'email' => 'admin@mail.com',
			'roles' => [Roles::ROLE_ADMIN],
			'password' => 'password',
		],
		[
			'email' => 'moderator@mail.com',
			'roles' => [Roles::ROLE_MODERATOR],
			'password' => 'password',
		],
		[
			'email' => 'redactor@mail.com',
			'roles' => [Roles::ROLE_REDACTOR],
			'password' => 'password',
		],
		[
			'email' => 'user@mail.com',
			'roles' => [Roles::ROLE_USER],
			'password' => 'password',
		],
	];

	public function load(ObjectManager $manager): void
	{
		foreach (self::$fixtures as $fixture) {
			$folk = new Folk();

			foreach ($fixture as $key => $value) {
				$method = 'set' . ucfirst($key);

				if (method_exists($folk, $method)) {
					$folk->$method($value);
				}
			}

			$manager->persist($folk);
		}

		$manager->flush();
	}

	public static function getGroups(): array
	{
		return ['dev', 'test'];
	}
}
