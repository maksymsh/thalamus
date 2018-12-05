<?php

namespace WWSC\ThalamusBundle\Form\API;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentAPIForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea',
                array(
                    'label' => 'Description',
                    'required' => true,
                    'constraints' => array(
                        new NotBlank(),
                        new Length(array('min' => 4)
                        ),
                    ),
                )
            )
            ->add('task', 'integer',
                array(
                    'label' => 'Task',
                    'required' => true,
                    'constraints' => array(
                        new NotBlank(),
                    ),
                )
            )
            ->add('title', 'text',
                array(
                    'label' => 'New task name',
                    'required' => true,
                    'constraints' => array(
                        new NotBlank(),
                        new Length(array('min' => 2)
                        ),
                    ),
                )
            )
            ->add('fastTrack', 'text', array(
                'label' => 'Fast Track',
                'required' => false,
            ))
            ->add('annotations', 'textarea', array('label' => 'Annotations'))
            ->add('image', 'textarea',
                array(
                    'label' => 'File(format:base64)',
                    'required' => true,
                    'constraints' => array(
                        new NotBlank(),
                    ),
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wwsc_thalamusbundle_save_comment';
    }
}
