<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationForm extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('first_name', 'text', array('label' => 'First name', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('last_name', 'text', array('label' => 'Last name', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('email', 'email', array('label' => 'Email', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('account', 'text', array('label' => 'Company', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'label_attr' => array('class' => 'control-label'),
                'required' => true,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => false, 'attr' => array('class' => 'form-control', 'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}', 'title' => 'Password incorrect. 6 characters necessary including 1 uppercase and 1 numeric', 'placeholder' => 'Password')),
                'second_options' => array('label' => false, 'attr' => array('class' => 'form-control', 'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}', 'title' => 'Password incorrect. 6 characters necessary including 1 uppercase and 1 numeric',  'placeholder' => 'Confirm password')),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('timezone', 'readabletimezone', array('label' => 'Time zone', 'label_attr' => array('class' => 'control-label col-md-2'), 'data' => 'Europe/Amsterdam', 'attr' => array('class' => 'form-control timezone-field')))
            ->add('profile', new UserProfileForm());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\User',
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'registration_account';
    }
}
