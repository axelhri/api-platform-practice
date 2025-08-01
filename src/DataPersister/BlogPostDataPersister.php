<?php

namespace App\DataPersister;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\BlogPost;
use App\Repository\FolkRepository;
use Symfony\Bundle\SecurityBundle\Security;

class BlogPostDataPersister implements ProcessorInterface {
    public function __construct(private Security $security, private ProcessorInterface $processor, private FolkRepository $folkRepository)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $user = $this->security->getUser();
        $data->setAuthor($user);
        return $this->processor->process($data, $operation, $uriVariables, $context);
    }

}
