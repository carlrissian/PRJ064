<?php

namespace Shared\EventSubscribers\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthorizationRequestSubscriber implements EventSubscriberInterface
{

    // Responsable de comprobar si el usuario está autenticado y no ha caducado la sesión
    // Si el usuario está autenticado y no ha caducado la sesión se añade el token en Cookies de la petición

    /**
     * @param RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event)
    {
        // TODO BUG: REVISAR POR QUÉ SE REALIZAN LLAMADAS A LOGIN NE SEGUNDO PLANO AL CARGAR PÁGINAS


        if (!$event->isMasterRequest() || isset($_ENV['APP_SECURITY_LOGIN_ENABLED']) && $_ENV['APP_SECURITY_LOGIN_ENABLED'] == 0) {
            return;
        }

        $request = $event->getRequest();

        $route = $event->getRequest()->attributes->get("_route");

        $routesToIgnoreEnv = $_ENV['ROUTES_TO_IGNORE_AUTH'];
        if(strpos($routesToIgnoreEnv, ',')){
            $routesToIgnoreEnv = explode(',', $_ENV['ROUTES_TO_IGNORE_AUTH']);
        }
        if(is_array($routesToIgnoreEnv)) {
            $routesToIgnore = $routesToIgnoreEnv;
        }else{
            $routesToIgnore = [$routesToIgnoreEnv];
        }

        if(!in_array($route, $routesToIgnore)) {

            $now = new \DateTime();
            if(
                !isset($_SESSION['NextSapSessionId']) ||
                !isset($_SESSION['SapSessionId']) ||
                ($_SESSION['NextSapSessionId']<$now->getTimestamp())
            ) {
                if (session_status() !== PHP_SESSION_NONE) {
                    session_destroy();
                }

                if( $request->getRequestUri() &&
                    strpos($request->getRequestUri(), '/_wdt/' ) === false ){
                    session_start();
                    $_SESSION['redirectUrl'] = $request->getRequestUri();
                }

                $event->setResponse(new RedirectResponse('/login' ));
            }else{
                $request->cookies->set('connect_sid', $_SESSION['SapSessionId']);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}