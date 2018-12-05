<?php

namespace WWSC\ThalamusBundle\Listener;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\SecurityContextInterface;

class PageLoadListener extends controller
{
    protected $container;
    protected $security_context;

    public function __construct(SecurityContextInterface $security_context, Container $container)
    {
        $this->container = $container;
        $this->security_context = $security_context;
    }

    public function onKernelRequest(GetResponseEvent $event){
        $request = $event->getRequest();
        $session = $request->getSession();
        $request->setLocale($session->get('_localeThalamus'));
        if($this->security_context->getToken() && $this->security_context->getToken()->getUser() && 'anon.' != $this->security_context->getToken()->getUser() && !$request->getSession()->get('account')){
            if($lastLoggedAccount = $this->security_context->getToken()->getUser()->getLastLoggedAccount()){
                $oAccount = $this->container->get('doctrine')->getRepository('WWSCThalamusBundle:Account')->find($lastLoggedAccount);
                $session->set('account', (object) array('slug' => $oAccount->getSlug(), 'name' => $oAccount->getName(), 'id' => $oAccount->getId()));
            }
        }
    }
}