<?php

namespace WWSC\ThalamusBundle\Command;

use Doctrine\ORM\QueryBuilder;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WWSC\ThalamusBundle\Entity\Comment;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use WWSC\ThalamusBundle\Entity\Task;
use WWSC\ThalamusBundle\Entity\TaskItem;

class RecurringTasktRunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cron:recursive-task')
            ->setDescription('Creating task based on recursive task ');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating task based on recursive task');

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $newTaskCount = 0;

        $currentDay = date('j');
        $currentMonth = date('n');
        $currentDayOfWeek = date('N');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));

        /**
         * @var QueryBuilder
         */
        $qb = $em->createQueryBuilder();
        $qb->select('ti')
            ->from('WWSC\ThalamusBundle\Entity\TaskItem', 'ti')
            ->join('WWSC\ThalamusBundle\Entity\Task', 't', 'WITH', '(ti.task = t.id and t.recursive = 1 and t.is_deleted = 0 and ti.status = 0)')
            ->join('WWSC\ThalamusBundle\Entity\Project', 'p', 'WITH', '(t.project = p.id AND p.is_deleted = 0 AND p.closed_project = 0)')
            ->where('ti.is_deleted = 0')
            ->andWhere('ti.status = 0')
            ->andWhere('ti.recursive = 1');

        if ($daysInMonth < 31 && $currentDay == $daysInMonth) {
            $aDays = array();
            while ($daysInMonth <= 31) {
                $aDays[$daysInMonth] = $daysInMonth;
                ++$daysInMonth;
            }
            $sqlWhereRecursion = '(ti.day_of_recursion IN('.implode(',', $aDays).') AND ti.type_period_recursion <> 0)';
        } else {
            $sqlWhereRecursion = '(ti.day_of_recursion = '.$currentDay.' AND  ti.type_period_recursion <> 0)';
        }
        $sqlWhereRecursion .= " OR ( ti.type_period_recursion = 0 AND ti.days_weekly_of_recursion LIKE '%$currentDayOfWeek%')";
        $qb->andWhere($sqlWhereRecursion);

        if ($aTasks = $qb->getQuery()->getResult()) {
            /**
             * @var TaskItem $oTask
             */
            foreach ($aTasks as $oTask) {
                if (0 == $oTask->getTypePeriodRecursion() || 0 == ($oTask->getMonthOfRecursion() - $currentMonth) % $oTask->getTypePeriodRecursion()) {
                    $token = new UsernamePasswordToken($oTask->getUserCreated(), null, 'main', $oTask->getUserCreated()->getRoles());
                    $this->getContainer()->get('security.context')->setToken($token);

                    $descriptionRecursion = $oTask->getDescriptionRecursive();

                    $newTask = clone $oTask;
                    $newTask->setShowDescriptionRecursive(0);
                    $newTask->setDayOfRecursion(0);
                    $newTask->setRecursive(0);

                    if ($oTask->getRecurringTaskList()) {
                        $newTask->setTask($em->getRepository('WWSCThalamusBundle:Task')->find($oTask->getRecurringTaskList()));
                    }

                    $newTask->setDescriptionRecursive(NULL);

                    $em->persist($newTask);
                    $em->flush();
                    ++$newTaskCount;

                    $aSubspeople = $oTask->getActiveSubscribed();
                    \WWSC\ThalamusBundle\Entity\SubscribeEmail::saveSubscribeEmail($aSubspeople, $newTask->getId(), 'TaskItem');

                    if (trim($descriptionRecursion)) {
                        $this->sendMailToAssignedUser($newTask);
                        $this->addComment($newTask, $descriptionRecursion);
                        $this->sendSubscribeEmail($newTask, 'task');
                    } else {
                        $this->sendSubscribeEmail($newTask, 'task');
                    }
                }
            }

            $output->writeln('New count tasks: '.$newTaskCount);
        }
    }

    private function addComment($oObj, $description)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $oComment = new Comment();
        $oComment->setDescription($description);
        $oComment->setParentId($oObj->getId());
        $oComment->setType('TaskItem');
        $em->persist($oComment);
        $em->flush();
        $this->sendSubscribeEmail($oComment);
    }

    public function sendSubscribeEmail($object, $type = 'comment')
    {
        /**
         * @var Logger $logger
         */
        $logger = $this->getContainer()->get('logger');

        if ('comment' == $type) {
            $subject = 'Re:['.$object->getParentInfo()->getTask()->getProject()->getName().'] '.$object->getParentInfo()->getDescription();
            $template = 'subscribe_comment_to_task.txt.twig';
            $priotity = $object->getParentInfo()->getFastTrack() ? 2 : 3;
            $aUsers = $object->getParentInfo()->getActiveSubscribed('info', $object->getPrivate());
            $replyUID = $object->getParentInfo()->getReplyUID();
        } else if ('task' == $type) {
            $subject = 'Re:['.$object->getTask()->getProject()->getName().'] '.$object->getDescription();
            $template = 'subscribe_recurring_task.txt.twig';
            $priotity = $object->getFastTrack() ? 2 : 3;
            $aUsers = $object->getActiveSubscribed('info');
            $replyUID = $object->getReplyUID();
        }
        if ($aUsers) {
            if ('comment' == $type && false !== ($keyResponsible = array_search($object->getUserCreated()->getEmail(), $aUsers['email']))) {
                unset($aUsers['email'][$keyResponsible]);
            }
            foreach ($aUsers['email'] as $userEmailKey => $userEmail) {
                $aData = array(
                    'oElement' => $object,
                    'aUsers' => $aUsers['name'],
                    'roleUser' => '',
                );
                if (isset($aUsers['lang'][$userEmailKey])) {
                    $langTemplate = $aUsers['lang'][$userEmailKey];
                } else {
                    $langTemplate = 'en';
                }
                $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($this->getContainer()->getParameter('admin_email'))
                    ->setReplyTo(
                        $replyUID
                        .'@'.$this->getContainer()->getParameter('auto_reply_email_domain')
                    )
                    ->setContentType('text/html')
                    ->setPriority($priotity)
                    ->setTo($userEmail)
                    ->setBody($this->getContainer()->get('templating')->render('WWSCThalamusBundle:Mail:'.$langTemplate.'/'.$template, $aData));

                $result = $this->getContainer()->get('mailer')->send($message);

                $logger->debug('Message: '.$subject.'! status: '.$result);
            }
        }
    }

    public function sendMailToAssignedUser(TaskItem $oTask)
    {
        /**
         * @var Logger $logger
         */
        $logger = $this->getContainer()->get('logger');

        $subject = '['.$oTask->getTask()->getProject()->getName().'] Notification Email: '.$oTask->getDescription();
        $template = 'task_assigned_user.txt.twig';
        if ($oTask->getResponsible()->getLanguageCode()) {
            $langTemplate = $oTask->getResponsible()->getLanguageCode();
        } else {
            $langTemplate = 'en';
        }
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->getContainer()->getParameter('admin_email'))
            ->setReplyTo(
                $oTask->getReplyUID()
                .'@'.$this->getContainer()->getParameter('auto_reply_email_domain')
            )
            ->setContentType('text/html')
            ->setTo($oTask->getResponsible()->getEmail())
            ->setBody($this->getContainer()->get('templating')->render('WWSCThalamusBundle:Mail:'.$langTemplate.'/'.$template, array('oElement' => $oTask)));

        $result = $this->getContainer()->get('mailer')->send($message);

        $logger->debug('Message: '.$subject.'! status: '.$result);
    }
}
