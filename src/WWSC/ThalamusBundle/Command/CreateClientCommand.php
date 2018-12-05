<?php

namespace WWSC\ThalamusBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('oauth:create-client')
            ->setDescription('Creates a new client.')
            ->setHelp('This command creates a new oauth client.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array('/'));
        $client->setAllowedGrantTypes(array('refresh_token', 'authorization_code', 'password', 'https://thalamus.io/google/login', 'https://thalamus.io/api/v1/login'));
        $clientManager->updateClient($client);
    }
}