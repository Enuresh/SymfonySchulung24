<?php

namespace App\Search;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias]
final readonly class DatabaseEventSearch implements EventSearchInterface
{

    public function __construct(public EventRepository $repository)
    {
    }

    public function searchByName(?string $name = null): array
    {
        if (null === $name)
        {
            return $this->repository->findAll();
        }
        return $this->repository->searchLike($name);
    }
}