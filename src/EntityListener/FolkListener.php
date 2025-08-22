<?php

namespace App\EntityListener;

use App\Entity\Folk;
use App\Enum\Roles;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Autoconfigure(tags: ['doctrine.orm.entity_listener'], lazy: true) ]
readonly class FolkListener
{
	public function __construct(
		private UserPasswordHasherInterface $encoder
	) {
	}

	public function prePersist(Folk $folk): void
	{
		if ($folk->getPassword()) {
			$folk->setPassword($this->encoder->hashPassword($folk, $folk->getPassword()));
		}
		$folk->setRoles([...$folk->getRoles(), Roles::ROLE_USER]);
	}

	public function preUpdate(Folk $folk, PreUpdateEventArgs $event): void
	{
		if ($event->hasChangedField('password')) {
			$folk->setPassword($this->encoder->hashPassword($folk, $folk->getPassword()));
		}
	}
}
