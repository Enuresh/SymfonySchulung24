<?php

namespace App\Transformer;

use App\Entity\Organization;
use DateMalformedStringException;
use DateTimeImmutable;

class ApiToOrganizationTransformer implements ApiToEntityTransformerInterface
{
    /**
     * @throws DateMalformedStringException
     */
    public function transform(array $data): Organization
    {
        return (new Organization())
            ->setName($data['name'])
            ->setPresentation($data['presentation'])
            ->setCreatedAt(new DateTimeImmutable($data['createdAt']));
    }
}