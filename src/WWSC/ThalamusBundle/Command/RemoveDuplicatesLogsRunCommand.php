<?php

namespace WWSC\ThalamusBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WWSC\ThalamusBundle\Entity\Log;
use WWSC\ThalamusBundle\WWSCThalamusBundle;

class RemoveDuplicatesLogsRunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('logs:remove-dublicates-logs')
            ->setDescription('Remove dublicates logs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Remove dublicates logs');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $aLogs = $em->getRepository('WWSCThalamusBundle:Log')->findBy(array('objectType' => 'TaskItem', 'action' => 'Updated by'), array('id' => 'DESC'));
        foreach($aLogs as $oLog) {
            $idComentLog = WWSCThalamusBundle::getContainer()->get('database_connection')->query("SELECT MAX( id ) as comId FROM log WHERE id < {$oLog->getId()}")->fetchAll();
            if (isset($idComentLog[0]['comId']) && $oLogComment = $em->getRepository('WWSCThalamusBundle:Log')->find($idComentLog[0]['comId'])) {
                $aDataComment = (array) $oLogComment->getCreated();
                $createdAtComment = date('Y-m-d h:i:s', strtotime($aDataComment['date']) + 100);
                $aDataTask = (array) $oLog->getCreated();
                $createdAtTask = $aDataTask['date'];
                if ( 'Comment' == $oLogComment->getObjectType() && $oLogComment->getUser() == $oLog->getUser() && $oLogComment->getProject() == $oLog->getProject() && $createdAtComment > $createdAtTask) {
                    $em->remove($oLog);
                    $em->flush();
                }
            }
        }
    }
}
