<?php

namespace App\Transformer;

use App\Entity\Event;
use DateTimeImmutable;

class ApiToEventTransformer implements ApiToEntityTransformerInterface
{
    /**
     * @throws \DateMalformedStringException
     */
    public function transform(array $data): Event
    {
        return (new Event())
            ->setName($data['name'])
            ->setStartAt(new DateTimeImmutable($data['startDate']))
            ->setEndAt(new DateTimeImmutable($data['endDate']))
            ->setDescription($data['description'])
            ->setIsAccessible($data['accessible']);
    }
}