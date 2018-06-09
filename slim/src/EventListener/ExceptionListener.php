<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class ExceptionListener {

    public function onKernelException(GetResponseForExceptionEvent $event) {

        $exception = $event->getException();
        $message = sprintf(
                'Ocurrio un error: %s with code: %s', $exception->getMessage(), $exception->getCode()
        );

        if ($exception instanceof HttpExceptionInterface) {
            $status = $exception->getStatusCode();
        } else {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $msg = [
            'subject' => 'Se ha registador un error en el sistema',
            'msg' => $message,
            'status' => $status
                ];
     /*   
        $notify = $this->container->get('notify-to-admin');
        $logger = $this->container->get('logger-system');
      
        $notify->query(['role' => 'ROLE_SUPER_ADMIN']);
        $notify->send('email/exception-event.html.twig', $msg);
        $logger->write($msg);
      */
      
    }

}
