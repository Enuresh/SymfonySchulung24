<?php

namespace App\Consumer;

use App\Search\EventSearchInterface;
use SensitiveParameter;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class EventsApiConsumer implements EventSearchInterface
{
    public function __construct
    (
        private HttpClientInterface $eventsClient
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function searchByName(?string $name = null): array
    {
        // The third parameter of the `request` method is an array of options.
        return $this->eventsClient->request('GET', '/events', [
            'query' => ['name' => $name]
        ])->toArray();
    }
}