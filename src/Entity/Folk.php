<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\EntityListener\FolkListener;
use App\Enum\AppGroups;
use App\Enum\OaFormats;
use App\Enum\OaTypes;
use App\Enum\Roles;
use App\Repository\FolkRepository;
use App\Security\Voter\FolkVoter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: FolkRepository::class)]
#[ORM\EntityListeners([FolkListener::class])]
#[ApiResource(
	operations: [
		new Get(),
		new GetCollection(),
		new Patch(security: "is_granted('" . FolkVoter::EDIT . "', object"),
		new Delete(security: "is_granted('" . FolkVoter::DELETE . "', object"),
	],
	normalizationContext: ['groups' => [AppGroups::USER_READ]],
	denormalizationContext: ['groups' => [AppGroups::USER_WRITE]]
)]
class Folk implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[ORM\Column(type: OaTypes::INTEGER, unique: true)]
	#[ORM\GeneratedValue]
	#[Groups([AppGroups::USER_READ])]
	#[ApiProperty(
		readable: true,
		writable: false,
		required: true,
		identifier: true,
		openapiContext: [
			'type' => OaTypes::INTEGER,
			'format' => OaFormats::INTEGER_32BIT,
			'example' => '147'
		]
	)]
	private ?int $id = null;

	#[ORM\Column(type: OaTypes::STRING, length: 30, unique: true)]
	#[Groups([AppGroups::USER_READ, AppGroups::USER_WRITE])]
	#[ApiProperty(
		readable: true,
		writable: true,
		required: true,
		openapiContext: [
			'type' => OaTypes::STRING,
			'format' => OaFormats::STRING_BYTE,
			'example' => 'username'
		]
	)]
	private ?string $username = null;

	#[ORM\Column(type: OaTypes::STRING, length: 255, unique: true)]
	#[Groups([AppGroups::USER_READ, AppGroups::USER_WRITE])]
	#[ApiProperty(
		readable: true,
		writable: true,
		required: true,
		openapiContext: [
			'type' => OaTypes::STRING,
			'format' => OaFormats::EMAIL,
			'example' => 'mail@mail.com'
			]
	)]
	private ?string $email = null;

	#[ORM\Column(type: OaTypes::STRING, length: 255)]
	#[Groups([AppGroups::USER_WRITE])]
	#[ApiProperty(
		readable: false,
		writable: true,
		required: true,
		openapiContext: [
			'type' => OaTypes::STRING,
			'format' => OaFormats::STRING_PASSWORD,
			'example' => 'password'
			]
	)]
	private ?string $password = null;

	/**
	 * @var string[]
	 */
	#[ORM\Column(type: OaTypes::JSON)]
	#[Groups([AppGroups::ADMIN_READ])]
	#[ApiProperty(
		readable: true,
		writable: true,
		required: true,
		openapiContext: [
			'type' => OaTypes::JSON,
			'items' => ['type' => OaTypes::STRING],
			'example' => [Roles::ROLE_ADMIN, Roles::ROLE_USER],
			]
	)]
	private array $roles = [];

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getUsername(): ?string
	{
		return $this->username;
	}

	public function setUsername(?string $username): void
	{
		$this->username = $username;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(?string $email): void
	{
		$this->email = $email;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function setPassword(?string $password): void
	{
		$this->password = $password;
	}

	public function getRoles(): array
	{
		return array_unique([...$this->roles, Roles::ROLE_USER]);
	}

	/**
	 * @param string[] $roles
	 */
	public function setRoles(array $roles): void
	{
		$this->roles = array_unique($roles);
	}

	public function eraseCredentials(): void
	{
	}

	public function getUserIdentifier(): string
	{
		return $this->email;
	}
}
