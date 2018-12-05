<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AccountForm extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array('label' => 'Company', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
                ->add('abbreviation', 'text', array('error_bubbling' => true, 'label' => 'Abbreviation', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
                ->add('timeZone', 'readabletimezone', array('label' => 'Time Zone', 'data' => 'Europe/Amsterdam', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control time-zone')))
        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'wwsc_thalamusbundle_account';
    }
}
