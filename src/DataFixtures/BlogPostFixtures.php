<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Folk;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BlogPostFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
	/**
	 * @var array<array< string, string|string[]>>
	 */
	public static array $fixtures = [
		[
			'title' => 'BlogPost Title',
			'text' => 'BlogPost text'
		],
	];

	public function load(ObjectManager $manager): void
	{
		foreach (self::$fixtures as $fixture) {
			$blogPost = new blogPost();

			foreach ($fixture as $key => $value) {
				$method = 'set' . ucfirst($key);

				if (method_exists($blogPost, $method)) {
					$blogPost->$method($value);
				}
			}

			$author = $this->getReference('folk_redactor', Folk::class);
			$blogPost->setAuthor($author);
			$manager->persist($blogPost);
		}

		$manager->flush();
	}

	public static function getGroups(): array
	{
		return ['dev', 'test'];
	}

	public function getDependencies(): array
	{
		return [FolkFixtures::class];
	}
}
