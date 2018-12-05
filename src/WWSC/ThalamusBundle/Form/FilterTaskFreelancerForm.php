<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterTaskFreelancerForm extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//            ->add('filter_task_status', 'checkbox', array('required' => false, 'data' => true))
        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'filter_tasks';
    }
}