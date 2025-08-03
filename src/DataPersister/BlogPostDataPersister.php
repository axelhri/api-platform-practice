<?php

namespace App\DataPersister;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\BlogPost;
use App\Repository\FolkRepository;
use Symfony\Bundle\SecurityBundle\Security;

class BlogPostDataPersister implements ProcessorInterface {
    public function __construct(private Security $security, private ProcessorInterface $processor)
    {
    }

    public function supports(mixed $data, Operation $operation, array $context = []): bool
    {
        return $data instanceof BlogPost;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (!$this->supports($data, $operation, $context)) {
            return $this->processor->process($data, $operation, $uriVariables, $context);
        }
        if ($operation instanceof Post) {
            $user = $this->security->getUser();
            if ($user !== null) {
                $data->setAuthor($user);
            }
        }

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }

}
