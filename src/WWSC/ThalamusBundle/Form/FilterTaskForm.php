<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterTaskForm extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $aFilterDue = array(
            'today' => 'Today',
            'tomorrow' => 'Tomorrow',
            'this_week' => 'This week',
            'next_week' => 'Next week',
            'later' => 'Later',
            'no_date_set' => '(No date set)',
        );

        $builder
                ->add('filter_due', 'choice', array('label' => 'Show to-dos that are due', 'required' => false, 'choices' => $aFilterDue, 'empty_data' => null, 'empty_value' => 'Anytime', 'attr' => array('class' => 'form-control')))
                ->add('filter_task_status', 'checkbox', array('required' => false, 'data' => true))
        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'filter_tasks';
    }
}
