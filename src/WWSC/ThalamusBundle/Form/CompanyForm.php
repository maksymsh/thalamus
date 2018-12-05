<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;
use WWSC\ThalamusBundle\Entity\Company;

class CompanyForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', 'choice', array('label' => 'Permissions', 'label_attr' => array('class' => 'control-label col-md-2'), 'required' => true, 'empty_data' => null, 'empty_value' => '', 'choices' => Company::$aRoles, 'attr' => array('class' => 'form-control')))
            ->add('name', 'text', array('error_bubbling' => true, 'label' => 'Company Name', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('abbreviation', 'text', array('error_bubbling' => true, 'label' => 'Abbreviation', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('address1', 'text', array('label' => 'Address1', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('address2', 'text', array('label' => 'Address2', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('city', 'text', array('label' => 'City', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('state', 'text', array('label' => 'State', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control ')))
            ->add('rate_internal', 'text', array('label' => 'Rate internal', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control ')))
            ->add('rate_external', 'text', array('label' => 'Rate external', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control ')))
            ->add('expected_turnover', 'text', array('label' => 'Expected Turnover', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control ')))
            ->add('zip', 'text', array('label' => 'ZIP/Postal Code', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('webAddress', 'text', array('label' => 'Web Address', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('office', 'text', array('label' => 'Office', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('fax', 'text', array('label' => 'Fax', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('private', 'checkbox', array('label' => 'Private', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
            ->add('country', 'country', array('label' => 'Country', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('language', 'language', array('label' => 'Language', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('timeZone', 'readabletimezone', array('label' => 'Time Zone', 'data' => 'Europe/Amsterdam', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control time-zone')))
            ->add('logoFile', 'file', array('label' => 'Company logo', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
            ->add('logo', 'hidden');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\Company',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wwsc_thalamusbundle_company';
    }
}
