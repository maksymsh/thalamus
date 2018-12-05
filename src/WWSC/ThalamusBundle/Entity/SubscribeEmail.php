<?php

namespace WWSC\ThalamusBundle\Entity;

use WWSC\ThalamusBundle\WWSCThalamusBundle;
use Doctrine\ORM\Mapping as ORM;

/**
 * SubscribeEmail.
 *
 * @ORM\Entity
 * @ORM\Table(name="subscribe_email")
 */
class SubscribeEmail{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     *@ORM\ManyToOne(targetEntity="WWSC\ThalamusBundle\Entity\User")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=100)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="parent", type="integer")
     */
    private $parent;

    /**
     * Set user.
     *
     * @param int $user
     *
     * @return SubscribeEmail
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return SubscribeEmail
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set parent.
     *
     * @param int $parent
     *
     * @return SubscribeEmail
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public static function  saveSubscribeEmail($aSubspeople = array(), $parent, $type){
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $remove = $em->createQuery("DELETE FROM WWSC\ThalamusBundle\Entity\SubscribeEmail as se WHERE se.type='$type' and se.parent = $parent")->getResult();
        foreach($aSubspeople as $key => $val){
            $newSubs = new SubscribeEmail();
            $newSubs->setUser($em->getRepository('WWSCThalamusBundle:User')->find($val));
            $newSubs->setParent($parent);
            $newSubs->setType($type);
            $em->persist($newSubs);
        }
        $em->flush();
    }

    public static function sendSubscribeEmail($object, $type, $responsibleUser = false, $notSendResponsible = false) {
        $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
        $activeUser = WWSCThalamusBundle::getContainer()->get('security.context')->getToken()->getUser();
        $container = WWSCThalamusBundle::getContainer();
        $mailBodyBg = '#fff';

         switch($object->getType()){
                case 'TaskItem':

                    $state = '';
                    $statePrePrivate = '';
                    $statePostPrivate = '';
                    

                    if ($object instanceof Comment && $object->getParentInfo() instanceof TaskItem && $object->getParentInfo()->getState() === 'CLOSED') {
                        $state = '['.$object->getParentInfo()->getState().'] ';
                    }

                    // PRIVATE subject add-on to e-mail
                    if ($object instanceof Comment && $object->getParentInfo() instanceof TaskItem) {

                        /**
                         * @var Comment $privateData
                         */
                        $privateData = $object->getPrivate();

                        if($privateData) {
                            if($state == '') {
                                $statePrePrivate = '**[PRIVATE]** ';
                            } else {
                                $statePostPrivate = '[PRIVATE] ';
                            }
                            $mailBodyBg = '#ece8e8';

                        } else {
                            $mailBodyBg = '#fff';
                        }

                    }

                    $subject = $statePrePrivate.$state.$statePostPrivate.'#'.$object->getParentInfo()->getId().' · '.$object->getParentInfo()->getDescription().' · '.$object->getParentInfo()->getTask()->getProject()->getName();
                    $template = 'subscribe_comment_to_task.txt.twig';
                    $priotity = $object->getParentInfo()->getFastTrack() ? 2 : 3;
                    $aUsers = $object->getParentInfo()->getActiveSubscribed('info', $object->getPrivate());

                    break;
                case 'Message' :

                    $subject = 'Re:['.$object->getParentInfo()->getProject()->getName().'] '.$object->getParentInfo()->getTitle();
                    $template = 'subscribe_comment_to_message.txt.twig';
                    $priotity = 3;
                    $aUsers = $object->getParentInfo()->getActiveSubscribed('info');
                    break;
         }


        if($responsibleUser){

            $oResponsibleUser = $em->getRepository('WWSCThalamusBundle:User')->find($responsibleUser);
            if (0 == count($aUsers) || (!array_key_exists($oResponsibleUser->getEmail(), $aUsers['email']) && $responsibleUser != $activeUser->getId())) {
                $aData = array(
                     'oElement' => $object,
                     'bodyBg'   => $mailBodyBg
                );
                if($aUsers && count($aUsers) > 0){
                    $aData['aUsers'] = $aUsers['name'];
                }else{
                    $aData['aUsers'] = array($oResponsibleUser->getFirstName().' '.$oResponsibleUser->getLastName());
                }
                if('TaskItem' == $object->getType()){
                    $aData['roleUser'] = $oResponsibleUser->getCompany()->getRoles();
                }
                 if($oResponsibleUser->getLanguageCode()){
                    $langTemplate = $oResponsibleUser->getLanguageCode();
                }else{
                    $langTemplate = 'en';
                }
                $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($container->getParameter('admin_email'))
                    ->setReplyTo(
                            $object->getParentInfo()->getReplyUID()
                            .'@'.$container->getParameter('auto_reply_email_domain')
                    )
                    ->setContentType('text/html')
                    ->setPriority($priotity)
                    ->setTo($oResponsibleUser->getEmail())
                    ->setBody($container->get('templating')->render('WWSCThalamusBundle:Mail:'.$langTemplate.'/'.$template, $aData));

                $container->get('mailer')->send($message);
            }

        } else {

            if('TaskItem' == $object->getType() && true == $notSendResponsible){
                if (false !== ($keyResponsible = array_search($object->getParentInfo()->getResponsible()->getEmail(), $aUsers['email']))) {
                    unset($aUsers['email'][$keyResponsible]);
                }
            }

            if($aUsers){

                foreach ($aUsers['email'] as $userEmailKey => $userEmail) {

                    if($userEmailKey != $activeUser->getId()){
                        $aData = array(
                             'oElement' => $object,
                             'aUsers'   => $aUsers['name']
                        );
                        if('TaskItem' == $object->getType()){
                            $oUser = $em->getRepository('WWSCThalamusBundle:User')->find($userEmailKey);
                            $aData['roleUser'] = $oUser->getCompany()->getRoles();
                        }
                        if(isset($aUsers['lang'][$userEmailKey])){
                            $langTemplate = $aUsers['lang'][$userEmailKey];
                        }else{
                            $langTemplate = 'en';
                        }

                        $aData['bodyBg'] = $mailBodyBg;

                        $message = \Swift_Message::newInstance()
                                ->setSubject($subject)
                                ->setFrom($container->getParameter('admin_email'))
                                ->setReplyTo(
                                        $object->getParentInfo()->getReplyUID()
                                        .'@'.$container->getParameter('auto_reply_email_domain')
                                )
                                ->setContentType('text/html')
                                ->setPriority($priotity)
                                ->setTo($userEmail)
                                ->setBody($container->get('templating')->render('WWSCThalamusBundle:Mail:'.$langTemplate.'/'.$template, $aData));

                        $container->get('mailer')->send($message);
                    }
                }
            }
        }
    }
}
