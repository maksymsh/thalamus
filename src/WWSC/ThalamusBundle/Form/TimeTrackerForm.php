<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TimeTrackerForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'control-label col-md-2'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '2000'
                ],
                'required' => true
            ])
            ->add('time', TextType::class, [
                'label' => 'Time',
                'label_attr' => [
                    'class' => 'control-label col-md-2'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'pattern' => '^([0-9])*([.]([0-9]){1,2}|[:](([0-5][0-9])|([6-9])))?$'
                ]
            ])
            ->add('billable', 'checkbox', [
                'required' => false
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\TimeTracker',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wwsc_thalamusbundle_timetracker';
    }
}
