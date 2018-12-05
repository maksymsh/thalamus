<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterTimeTrackerForm extends AbstractType {
    private $lang;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function __construct($lang = false) {
        $this->lang = $lang;
    }

    public function getFormat($lang) {
        if ('de' == $lang) {
            $format = 'd/m/Y';
        } else {
            $format = 'm/d/Y';
        }

        return $format;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('filter_date_from', 'text', array('required' => false, 'empty_data' => date($this->getFormat($this->lang), strtotime('first day of this month')), 'attr' => array('class' => 'min-form-control datepicker', 'data-provide' => 'datepicker')))
                ->add('filter_date_to', 'text', array('required' => false, 'empty_data' => date($this->getFormat($this->lang)), 'attr' => array('class' => 'min-form-control datepicker', 'data-provide' => 'datepicker')))
                ->add('filter_task', 'text', array('required' => false, 'attr' => array('class' => 'min-form-control')))
                ->add('filter_hide_empty', 'checkbox', array('required' => false, 'data' => true))
                ->add('fast_track', 'choice', array('required' => false, 'choices' => array('yes' => 'Yes', 'no' => 'No'), 'empty_data' => null, 'empty_value' => '', 'attr' => array('class' => 'min-form-control')))
                ->add('filter_parent', 'text', array('required' => false, 'attr' => array('class' => 'min-form-control')))
        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'filter_time';
    }
}
