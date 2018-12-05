<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageForm extends AbstractType {
    private $category;

    public function __construct($category) {
        $this->category = $category;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array('required' => true, 'attr' => array('class' => 'form-control')))
            ->add('category', 'entity', array('class' => 'WWSC\ThalamusBundle\Entity\Category', 'required' => false, 'label_attr' => array('class' => 'control-label col-xs-2'), 'empty_data' => null, 'empty_value' => 'No category', 'choices' => $this->category, 'property' => 'name', 'attr' => array('data-type' => 'MESSAGE', 'class' => 'min-form-control select-category')))
            ->add('description', 'markdown', array('attr' => array('data-provide' => 'markdown', 'rows' => 5)))
            ->add('private', 'checkbox', array('label' => 'Private', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\Message',
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'wwsc_thalamusbundle_message';
    }
}
