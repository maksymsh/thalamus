<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;

class UserContactForm extends AbstractType {
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
                ->add('profile', new UserProfileForm())
                ->add('language', 'language', array('label' => 'Language', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
                ->add('company', 'entity', array('class' => 'WWSC\ThalamusBundle\Entity\Company', 'label_attr' => array('class' => 'control-label col-xs-2'), 'choices' => $this->accountCompanies, 'property' => 'name', 'attr' => array('class' => 'form-control')))
                ->add('avatarFile', 'file', array('label' => 'Upload your photo', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\User',
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'wwsc_thalamusbundle_user';
    }
}
