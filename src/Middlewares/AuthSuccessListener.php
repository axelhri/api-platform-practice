<?php

namespace App\Middlewares;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthSuccessListener {

    public function __construct(private CookieService $cookieService) {}

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void {
        $token = $event->getData()["token"];

        $cookie = $this->cookieService->generateCookie($token);

        $response = $event->getResponse();
        $response->headers->setCookie($cookie);
    }
}
