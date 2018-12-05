<?php

namespace WWSC\ThalamusBundle\Service;


use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MailService extends Controller
{
    protected $mailer;
    
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($subject, $from, $to, $body)
    {
        $message = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setContentType('text/html')
            ->setTo($to)
            ->setBody($body);
        $this->mailer->send($message);
    }
}