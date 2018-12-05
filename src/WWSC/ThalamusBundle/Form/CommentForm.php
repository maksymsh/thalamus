<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentForm extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('description', 'markdown', array('attr' => array('data-provide' => 'markdown', 'rows' => 5)))
            ->add('private', 'checkbox', array('label' => 'Private', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control'))) 
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\Comment',
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'wwsc_thalamusbundle_comment';
    }
}
