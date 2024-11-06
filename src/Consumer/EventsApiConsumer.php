<?php

namespace App\Consumer;

use App\Search\EventSearchInterface;
use SensitiveParameter;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class EventsApiConsumer implements EventSearchInterface
{
    public function __construct
    (
        #[SensitiveParameter]
        #[Autowire(env: 'EVENTS_API_KEY')]
        private string $apiKey
    )
    {
    }

    public function searchByName(?string $name = null): array
    {
        $this->apiKey;
        return [];
    }
}