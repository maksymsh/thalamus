<?php

namespace WWSC\ThalamusBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class FormValidationService
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function isDuplicateUrl($abbreviation, $projectId)
    {
        $em = $this->container->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('count(p.id)')
            ->from('WWSC\ThalamusBundle\Entity\Project', 'p')
            ->join('p.responsible_company', 'comp')
            ->where("comp.abbreviation = '{$abbreviation}'")
            ->andWhere('p.project_id = '.$projectId)
            ->setMaxResults(1);
        if ($result = $qb->getQuery()->getSingleResult()) {
            return $result[1];
        }

        return false;
    }
}