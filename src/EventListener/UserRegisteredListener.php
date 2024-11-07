<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Event\UserRegisteredEvent;
use Exception;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final class UserRegisteredListener
{

    /**
     * @throws Exception
     */
    public function __invoke(UserRegisteredEvent $event): void
    {
        throw new Exception('Registration erfolgreich!');
    }
}
