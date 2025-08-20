<?php

namespace App\Middlewares;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener {

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();

        $payload = $event->getData();

        $payload['username'] = $user->getEmail();

        $event->setData($payload);
    }
}
