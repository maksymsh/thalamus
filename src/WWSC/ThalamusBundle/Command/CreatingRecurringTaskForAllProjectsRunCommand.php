<?php

namespace WWSC\ThalamusBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WWSC\ThalamusBundle\Entity\Project;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use WWSC\ThalamusBundle\Entity\Task;

class CreatingRecurringTaskForAllProjectsRunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('recurringTasks:creating-for-all-projects')
            ->setDescription('Creating Recurring Task for all Projects ');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating Recurring Task for all Projects');
        $container = $this->getContainer();
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $aProjects = $em->getRepository('WWSCThalamusBundle:Project')->findBy(array('is_deleted' => 0));   
        foreach($aProjects as $oProject){
            $token = new UsernamePasswordToken($oProject->getUserCreated(), null, 'main', $oProject->getUserCreated()->getRoles());
            $this->getContainer()->get('security.context')->setToken($token);

            /*Creating Recurring Task*/
           $oRecurtionTask = new Task();
           $oRecurtionTask->setName('Recurring Task');
           $oRecurtionTask->setProject($oProject);
           $oRecurtionTask->setVisibleClient(1);
           $oRecurtionTask->setVisibleFreelancer(1);
           $oRecurtionTask->setRecursive(1);
           $em->persist($oRecurtionTask);
           $em->flush();
     }
    }
}
