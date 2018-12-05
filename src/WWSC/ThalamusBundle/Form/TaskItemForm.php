<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WWSC\ThalamusBundle\Entity\TaskItem;

class TaskItemForm extends AbstractType {
    private $responsible;
    private $aRecurringTaskList;

    public function __construct($responsible, $aRecurringTaskList) {
        $this->responsible = $responsible;
        $this->aRecurringTaskList = $aRecurringTaskList;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('due_date_form', 'text', array(
                    'required' => false,
                    'attr' => array('class' => 'form-control datepicker', 'data-provide' => 'datepicker'),
                ))
                ->add('status', 'checkbox', array(
                    'label' => 'Status',
                    'required' => false,
                    'label_attr' => array('class' => 'control-label'),
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('description', 'textarea', array(
                    'error_bubbling' => true,
                    'attr' => array('class' => 'form-control', 'rows' => '5', 'pattern' => '.{4,255}'),
                ))
                ->add('responsible', 'entity', array(
                    'error_bubbling' => false,
                    'class' => 'WWSC\ThalamusBundle\Entity\User',
                    'empty_data' => null,
                    'empty_value' => 'Anyone',
                    'label_attr' => array('class' => 'control-label col-xs-2'),
                    'choices' => $this->responsible,
                    'property' => 'firstName',
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('state', 'choice', array(
                    'choices' => TaskItem::$states,
                    'empty_data' => null,
                    'empty_value' => 'Select please ...',
                    'required' => false,
                    'label_attr' => array('class' => 'control-label col-xs-2'),
                    'attr' => array('class' => 'form-control task-item-state'),
                ))
                ->add('fast_track', 'checkbox', array(
                    'required' => false,
                ))
                ->add('show_description_recursive', 'checkbox', array(
                    'required' => false,
                ))
                ->add('day_of_recursion', 'choice', array(
                    'empty_data' => null,
                    'empty_value' => '',
                    'choices' => TaskItem::getDayMonth(),
                    'required' => false,
                    'label_attr' => array('class' => 'control-label col-xs-2'),
                    'attr' => array('class' => 'form-control col-xs-2'),
                ))
                ->add('month_of_recursion', 'choice', array(
                    'empty_data' => null,
                    'empty_value' => '',
                    'choices' => TaskItem::getMonth(),
                    'required' => false,
                    'label_attr' => array('class' => 'control-label col-xs-2'),
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('type_period_recursion', 'choice', array(
                    'choices' => TaskItem::$aTypePeriodRecursion,
                    'required' => true,
                    'expanded' => true,
                    'label_attr' => array('class' => 'control-label col-xs-2'),
                    'attr' => array('class' => 'radio-group'),
                ))
                ->add('description_recursive', 'markdown', array(
                    'error_bubbling' => true,
                    'required' => false,
                    'attr' => array('class' => 'form-control markdown-mini', 'data-provide' => 'markdown', 'rows' => '5'),
                ))
               ->add('estimated','text', array(
                   'label' => 'Estimated Time',
                   'required' => false,
                   'label_attr' => array('class' => 'control-label col-md-2'),
                   'attr' => array('class' => 'form-control', 'pattern' => '^([0-9])*([.]([0-9]){1,2}|[:](([0-5][0-9])|([6-9])))?$'),
                ))
                ->add('recurring_task_list', 'choice', array(
                    'empty_data' => null,
                    'empty_value' => 'Select please ...',
                    'choices' => $this->aRecurringTaskList,
                    'required' => false,
                    'label_attr' => array('class' => 'control-label col-xs-2'),
                    'attr' => array('class' => 'form-control task-item-state'),
                ))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\TaskItem',
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'wwsc_thalamusbundle_task_item';
    }
}
