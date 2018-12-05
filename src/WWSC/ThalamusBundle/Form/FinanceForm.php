<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WWSC\ThalamusBundle\Entity\Finance;

class FinanceForm extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('due_date', 'text', array(
                    'attr' => array('class' => 'form-control datepicker', 'data-provide' => 'datepicker'),
                ))
                ->add('invoice_date', 'text', array(
                    'attr' => array('class' => 'form-control datepicker', 'data-provide' => 'datepicker'),
                ))
                ->add('status', 'choice', array(
                    'label' => 'Status',
                    'choices' => Finance::$aStatus,
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('vat_rate', 'choice', array(
                    'label' => 'VAT rate',
                    'choices' => Finance::$aVATrate,
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('description', 'textarea', array(
                    'attr' => array('class' => 'form-control', 'rows' => '5', 'pattern' => '.{4,255}'),
                ))
                ->add('billable', 'checkbox', array(
                    'required' => false,
                ))
                ->add('recorder_cost', 'checkbox', array(
                    'required' => false,
                ))
                ->add('amount', 'text', array(
                    'attr' => array('class' => 'form-control', 'pattern' => '^-?\d+((.|,)\d{0,2})?'),
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\Finance',
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'wwsc_thalamusbundle_finance';
    }
}
