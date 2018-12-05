<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SubscribeEmailController extends Controller {
    /**
     *  Method remove me subscribe to comment or message.
     *
     *  Method responsible for remove my user subscription on comments or messages
     */   
    public function removeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $userSubscribed = $this->getDoctrine()->getRepository('WWSCThalamusBundle:SubscribeEmail')->findOneBy(array(
            'type' => $request->get('type'),
            'parent' => $request->get('parent'),
            'user' => $this->getUser(),
        ));
        $em->remove($userSubscribed);
        $em->flush();

        $referer = $request->headers->get('referer');

        return new RedirectResponse($referer);
    }

    /**
     *  Method add me subscribe to comment or message.
     *
     *  Method responsible for add my user subscription on comments or messages
     */    
    public function addAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $newSubs = new \WWSC\ThalamusBundle\Entity\SubscribeEmail();
        $newSubs->setUser($this->getUser());
        $newSubs->setParent($request->get('parent'));
        $newSubs->setType($request->get('type'));
        $em->persist($newSubs);
        $em->flush();

        $referer = $request->headers->get('referer');

        return new RedirectResponse($referer);
    }
}
