<?php

namespace App\Middlewares;

use Symfony\Component\HttpFoundation\Cookie;

class CookieService
{
    public function generateCookie(string $token) {
        return Cookie::create('access_token')
            ->withValue($token)
            ->withExpires(new \DateTime('+1 hour'))
            ->withHttpOnly(true)
            ->withSecure(false)
            ->withPath('/');
    }

    public function deleteCookie() {
        return Cookie::create('access_token')
            ->withValue('')
            ->withExpires(new \DateTime('-1 hour'))
            ->withHttpOnly(true)
            ->withSecure(false)
            ->withPath('/');
    }

}
