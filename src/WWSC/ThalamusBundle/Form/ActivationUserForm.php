<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActivationUserForm extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//                ->add('username', null, array('label' => 'form.username', 'data' => '', 'label_attr' => array("class" => 'control-label col-md-2'), 'translation_domain' => 'FOSUserBundle', 'attr' => array('class' => 'form-control', 'placeholder' => 'Username', 'pattern' => '.{3,255}')))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'label_attr' => array('class' => 'control-label'),
                    'required' => true,
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => false, 'data' => '', 'attr' => array('class' => 'form-control', 'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}', 'placeholder' => 'Password')),
                    'second_options' => array('label' => false, 'data' => '', 'attr' => array('class' => 'form-control', 'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}',  'placeholder' => 'Confirm password')),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))
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
        return 'wwsc_thalamusbundle_activation_user';
    }
}
