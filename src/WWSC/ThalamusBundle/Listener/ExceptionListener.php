<?php

namespace WWSC\ThalamusBundle\Listener;

use Monolog\Logger;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class ExceptionListener
{
    protected $templating;
    protected $kernel;
    protected $logger;

    public function __construct(EngineInterface $templating, $kernel, Logger $logger)
    {
        $this->templating = $templating;
        $this->kernel = $kernel;
        $this->logger = $logger;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ('prod5' == $this->kernel->getEnvironment()){
            $exception = $event->getException();
            $response = new Response();
            $response->setContent(
                $this->templating->render(
                    '::exception.html.twig',
                    array('exception' => $exception)
                )
            );
            if ($exception instanceof HttpExceptionInterface) {
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
            } else {
                $this->logger->critical('CRITICAL: '.$exception->getMessage().$exception->getTraceAsString());
                $response->setStatusCode(500);
            }
            $event->setResponse($response);
        }
    }
} 