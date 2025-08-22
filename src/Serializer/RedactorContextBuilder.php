<?php

namespace App\Serializer;

use ApiPlatform\State\SerializerContextBuilderInterface;
use App\Enum\AppGroups;
use App\Enum\Roles;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RedactorContextBuilder implements SerializerContextBuilderInterface
{
	public function __construct(
		private SerializerContextBuilderInterface $serializerContextBuilder,
		private AuthorizationCheckerInterface $authorizationChecker,
	) {
	}

	/**
	 * @param Request $request
	 * @param bool $normalization
	 * @param array<string, mixed>|null $extractedAttributes
	 * @return array<string, mixed>
	 */
	public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
	{
		$context = $this->serializerContextBuilder->createFromRequest($request, $normalization, $extractedAttributes);

		if ($normalization && $this->authorizationChecker->isGranted(Roles::ROLE_REDACTOR)) {
			$context['groups'][] = AppGroups::REDACTOR_READ;
		}

		return $context;
	}
}
