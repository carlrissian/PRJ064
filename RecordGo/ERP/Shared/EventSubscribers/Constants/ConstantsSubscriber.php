<?php

namespace Shared\EventSubscribers\Constants;

use Shared\Constants\Application\FilterConstants\FilterConstantsQueryHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ConstantsSubscriber implements EventSubscriberInterface
{
    private $handler;

    public function __construct(FilterConstantsQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get("_route");
        $method = $event->getRequest()->getMethod();

        //SI ES RESPUESTA APP_LOGIN Y EXISTE SESIÓN SAP SE OBTIENEN LAS CONSTANTES
        if($event->isMasterRequest() && $route === 'app_login' && $method === 'POST' && isset($_SESSION['SapSessionId'])) {
            $this->handler->handle();
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse'
        ];
    }
}