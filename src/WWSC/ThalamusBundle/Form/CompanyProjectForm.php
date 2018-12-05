<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use WWSC\ThalamusBundle\Entity\Company;

class CompanyProjectForm extends AbstractType {
    private $accountCompanies;

    public function __construct($accountCompanies) {
        $this->accountCompanies = $accountCompanies;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('company', 'entity', array('class' => 'WWSC\ThalamusBundle\Entity\Company', 'choices' => $this->accountCompanies, 'property' => 'name', 'empty_data' => null, 'empty_value' => '', 'attr' => array('class' => 'min-form-control')))
            ->add('access_to_all_people', 'checkbox',array('required' => false, 'data' => true))
        ;
    }

    /**
    /**
     * @return string
     */
    public function getName() {
        return 'wwsc_thalamusbundle_company_project';
    }
}
