<?php

namespace WWSC\ThalamusBundle\Handler;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    public function onLogoutSuccess(Request $request)
    {
        if (isset($_COOKIE['access_token'])) {
            unset($_COOKIE['access_token']);
            setcookie('access_token', null, -1, '/');
        }
        $referer = $request->headers->get('referer');

        return new RedirectResponse($referer);
    }
}