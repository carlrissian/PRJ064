<?php

namespace Shared\EventSubscribers\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthorizationResponseSubscriber implements EventSubscriberInterface
{

    // Responsable de comprobar Código respuesta de la petición
    // Si la respuesta es No autorizado 401 se redirige a la página de login y se borran los datos de sesión
    public function onKernelResponse(ResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get("_route");


        if(in_array($route, ["app_login"]) || isset($_ENV['APP_SECURITY_LOGIN_ENABLED']) && $_ENV['APP_SECURITY_LOGIN_ENABLED'] == 0) {
            return;
        }

        $resposne = $event->getResponse();
        if ($resposne->getStatusCode() === 401) {
            if (session_status() !== PHP_SESSION_NONE) {
                session_destroy();
            }
            return new RedirectResponse('/login');
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}