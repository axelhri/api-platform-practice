<?php

declare(strict_types=1);

namespace App\Tests\Trait\DataProvider;

trait FormatDataProviderTrait
{
	/**
	 * @param object[] $objects
	 */
	protected static function formatFixtureDataForDataProvider(array $objects): \Generator
	{
		foreach ($objects as $object) {
			yield [$object];
		}
	}
}
