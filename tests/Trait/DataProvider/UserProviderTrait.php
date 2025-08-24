<?php

declare(strict_types=1);

namespace App\Tests\Trait\DataProvider;

use App\Entity\Folk;
use App\Enum\Roles;
use App\Repository\FolkRepository;

trait UserProviderTrait
{
	use FormatDataProviderTrait;

	public static function provideUsersFromDoctrine(): \Generator
	{
		/** @var FolkRepository $folkRepository */
		$folkRepository = static::getContainer()->get(FolkRepository::class);

		yield from static::formatFixtureDataForDataProvider($folkRepository->findAll());
	}

	public static function provideAdmin(): Folk
	{
		/** @var FolkRepository $folkRepository */
		$folkRepository = static::getContainer()->get(FolkRepository::class);

		return $folkRepository->findOneBy(['email' => 'admin@mail.com']);
	}

	public static function provideModerator(): Folk
	{
		/** @var FolkRepository $folkRepository */
		$folkRepository = static::getContainer()->get(FolkRepository::class);

		return $folkRepository->findOneBy(['email' => 'moderator@mail.com']);
	}

	public static function provideRedactor(): Folk
	{
		/** @var FolkRepository $folkRepository */
		$folkRepository = static::getContainer()->get(FolkRepository::class);

		return $folkRepository->findOneBy(['email' => 'redactor@mail.com']);
	}

	public static function provideUser(): Folk
	{
		/** @var FolkRepository $folkRepository */
		$folkRepository = static::getContainer()->get(FolkRepository::class);

		return $folkRepository->findOneBy(['email' => 'user@mail.com']);
	}
}
