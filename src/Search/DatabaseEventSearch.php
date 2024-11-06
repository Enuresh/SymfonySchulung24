<?php

namespace App\Search;

use App\Entity\Event;
use App\Repository\EventRepository;

final readonly class DatabaseEventSearch
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