<?php

namespace Shared\EventSubscribers\Logs;

use Shared\Domain\Logs\LogHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class LogSubscriber implements EventSubscriberInterface
{
    private $logHelper;

    public function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
    }
//
//    public function onKernelRequest(RequestEvent $event)
//    {
//        if($event->isMasterRequest()){
//
//            $type = 'INFO';
//
//            $host = $event->getRequest()->getHost();
//            $ip = $event->getRequest()->getClientIp();
//            $method = $event->getRequest()->getMethod();
//            $route = $event->getRequest()->attributes->get("_route");
//            $statusCode = 200;
//
//            // TODO: Extraer a método la construcción del mensaje
//            $messageArray = [
//                'route' => $route,
//                'host' => $host,
//            ];
//
//            if(isset($_SESSION['UserInfo'])){
//                $messageArray['user_login'] = $_SESSION['UserInfo']['username'];
//            }
//
//            if($method == 'POST'){
//                $content = $event->getRequest()->request->all();
//            }else{
//                $content = $event->getRequest()->getContent();
//            }
//            $messageArray['content'] = $content;
//            if($route === 'app_login'){
//              return;
//            }
//
//            $message = json_encode($messageArray);
//
//            $message = '['.$type.']['.$_ENV['APP_NAME'].'][REQUEST]: '.$message;
//
//            $this->logHelper->log($method, $statusCode, $ip, $message, $type);
//        }
//    }
//
//    public function onKernelResponse(ResponseEvent $event)
//    {
//        $headerContentType = $event->getResponse()->headers->get('Content-Type');
//        $method = $event->getRequest()->getMethod();
//        $route = $event->getRequest()->attributes->get("_route");
//
//        $ip = $event->getRequest()->getClientIp();
//
//        $proccessTime = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
//
//        $statusCode = $event->getResponse()->getStatusCode();
//
//        // TODO: Extraer a método la construcción del mensaje
//        $messageArray = [
//            'route' => $route,
//            'proccessTime' => $proccessTime,
//        ];
//        if(isset($_SESSION['UserInfo'])){
//            $messageArray['user_login'] = $_SESSION['UserInfo']['username'];
//        }
//
//        if($statusCode>=200 && $statusCode<400) {
//            $type = 'INFO';
//        }else if($statusCode>=400 && $statusCode<500) {
//            $type = 'WARNING';
//        }else {
//            $type = 'ERROR';
//        }
//
//        if($headerContentType == 'application/json'){
//            $content = $event->getResponse()->getContent();
//            $messageArray['content'] = $content;
//        }
//
//        $message = json_encode($messageArray);
//
//        $message = '['.$type.']['.$_ENV['APP_NAME'].'][RESPONSE]: '.$message;
//
//        $this->logHelper->log($method, $statusCode, $ip, $message, $type);
//    }

    public function onKernelException(ExceptionEvent $event)
    {
        $statusCode = $event->getException()->getCode();

        $route = $event->getRequest()->attributes->get("_route");

        $method = $event->getRequest()->getMethod();
        $content = $event->getRequest()->getContent();
        $exception = $event->getException()->getMessage();
        $host = $event->getRequest()->getHost();

        // TODO: Extraer a método la construcción del mensaje
        $messageArray = [
            'route' => $route,
            'host' => $host,
            'exception' => $exception,
            'content' => $content,
        ];

        if(isset($_SESSION['UserInfo']['username'])) {
            $messageArray['user_login'] = $_SESSION['UserInfo']['username'];
        }

        $message = json_encode($messageArray);

        $type = 'ERROR';
        $ip = $event->getRequest()->getClientIp();

        $message = '['.$type.']['.$_ENV['APP_NAME'].'][EXCEPTION]: '.$message;

        $this->logHelper->log($method, $statusCode, $ip, $message, $type);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}