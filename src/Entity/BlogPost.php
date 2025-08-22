<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\EntityListener\BlogPostListener;
use App\Enum\AppGroups;
use App\Enum\OaFormats;
use App\Enum\OaTypes;
use App\Security\Voter\BlogPostVoter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
	operations: [
		new Get(),
		new GetCollection(),
		new Post(securityPostDenormalize: "is_granted('" . BlogPostVoter::CREATE . "', object)"),
		new Patch(security: "is_granted('" . BlogPostVoter::EDIT ."', object)"),
		new Delete(security: "is_granted('" . BlogPostVoter::DELETE ."', object)"),
	],
	normalizationContext: ['groups' => [AppGroups::USER_READ]],
	denormalizationContext: ['groups' => [AppGroups::ADMIN_WRITE, AppGroups::REDACTOR_WRITE]]
)]
#[ORM\Entity]
#[ORM\EntityListeners([BlogPostListener::class])]
class BlogPost
{
	#[ORM\Id]
	#[ORM\Column(type: "integer")]
	#[ORM\GeneratedValue]
	#[Groups([AppGroups::USER_READ])]
	#[ApiProperty(
		readable: true,
		writable: false,
		required: true,
		openapiContext: [
			'type' => OaTypes::INTEGER,
			'format' => OaFormats::INTEGER_32BIT,
			'example' => '32'
		]
	)]
	private int $id;

	#[ORM\Column(type: 'string', length: 50)]
	#[Groups([AppGroups::USER_READ, AppGroups::ADMIN_WRITE, AppGroups::REDACTOR_WRITE])]
	#[ApiProperty(
		readable: true,
		writable: true,
		required: true,
		openapiContext: [
			'type' => OaTypes::STRING,
			'format' => OaFormats::STRING_BYTE,
			'example' => 'BlogPost Title'
			]
	)]
	private string $title;

	#[ORM\Column(type: 'string')]
	#[Groups([AppGroups::USER_READ, AppGroups::ADMIN_WRITE, AppGroups::REDACTOR_WRITE])]
	#[ApiProperty(
		readable: true,
		writable: true,
		required: true,
		openapiContext: [
			'type' => OaTypes::STRING,
			'format' => OaFormats::STRING_BYTE,
			'example' => 'BlogPost Text'
		]
	)]
	private string $text;

	#[ORM\Column(type: 'datetime_immutable', nullable: false)]
	#[Groups([AppGroups::USER_READ])]
	private \DateTimeImmutable $createdAt;

	#[ORM\Column(type: 'datetime', nullable: true)]
	#[Groups([AppGroups::ADMIN_READ, AppGroups::REDACTOR_READ])]
	private ?\DateTime $updatedAt = null;

	#[ORM\ManyToOne(targetEntity: Folk::class, inversedBy: 'blogPosts')]
	#[ORM\JoinColumn(onDelete: 'CASCADE')]
	#[Groups([AppGroups::USER_READ])]
	private Folk $author;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getText(): string
	{
		return $this->text;
	}

	public function setText(string $text): void
	{
		$this->text = $text;
	}

	public function getCreatedAt(): ?\DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?\DateTimeImmutable $createdAt): void
	{
		$this->createdAt = $createdAt;
	}

	public function getUpdatedAt(): ?\DateTime
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(?\DateTime $updatedAt): void
	{
		$this->updatedAt = $updatedAt;
	}

	public function getAuthor(): ?Folk
	{
		return $this->author;
	}

	public function setAuthor(?Folk $author): void
	{
		$this->author = $author;
	}
}
