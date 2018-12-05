<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskForm extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array('label' => 'Name the project', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control', 'pattern' => '.{3,255}')))
            ->add('visible_client', 'checkbox', array('label' => 'Visible company client', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
            ->add('visible_freelancer', 'checkbox', array('label' => 'Visible company freelancer', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
            ->add('description', 'markdown', array('required' => false, 'attr' => array('data-provide' => 'markdown', 'class' => 'markdown-mini', 'rows' => 5))) 
            ->add('recursive','checkbox', array('required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
            ->add('is_time_tracker','checkbox', array('required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\Task',
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'wwsc_thalamusbundle_task';
    }
}
