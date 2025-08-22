<?php

namespace App\EntityListener;

use App\Entity\BlogPost;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(tags: ['doctrine.orm.entity_listener'], lazy: true)]
readonly class BlogPostListener
{
	public function prePersist(BlogPost $blogPost): void
	{
		$blogPost->setCreatedAt(new \DateTimeImmutable());
	}

	public function preUpdate(BlogPost $blogPost): void
	{
		$blogPost->setUpdatedAt(new \DateTime());
	}
}
