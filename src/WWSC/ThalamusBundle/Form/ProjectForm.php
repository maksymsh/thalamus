<?php

namespace WWSC\ThalamusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    private $company;
    private $tasks;
    private $users;

    public function __construct($company = null, $users = null, $tasks = null)
    {
        $this->company = $company;
        $this->users = $users;
        $this->tasks = $tasks;
    }

    public function getATasks()
    {
        $aTasks = array();
        if ($this->tasks) {
            foreach ($this->tasks as $oTask) {
                $aTasks[$oTask->getId()] = $oTask->getName();
            }
        }

        return $aTasks;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('responsible_company', 'entity', array('class' => 'WWSC\ThalamusBundle\Entity\Company', 'label_attr' => array('class' => 'control-label col-xs-2'), 'choices' => $this->company, 'property' => 'name', 'attr' => array('class' => 'form-control')))
            ->add('projectleader', 'entity', array('class' => 'WWSC\ThalamusBundle\Entity\User', 'label_attr' => array('class' => 'control-label col-xs-2'), 'choices' => $this->users, 'empty_value' => 'Select project lead', 'property' => 'fullName', 'attr' => array('class' => 'form-control')))
            ->add('name', 'text', array('label' => 'Name the project', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control', 'pattern' => '.{3,255}')))
            ->add('project_id', 'integer', array('label' => 'Project id', 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control')))
            ->add('description', 'markdown', array('required' => false, 'attr' => array('data-provide' => 'markdown', 'class' => 'markdown-mini', 'rows' => 5)))
            ->add('config', 'textarea', array('required' => false, 'attr' => array('label' => 'JSON-Config', 'class' => 'form-control', 'rows' => '5')))
            ->add('post_task_via_email', 'choice', array('choices' => $this->getATasks(), 'empty_value' => 'Select task list', 'attr' => array('class' => 'form-control'), 'required' => false))
            ->add('type', 'choice', array('choices' => array('1' => 'Fixed price', '2' => 'Time & material'), 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('budget', 'text', array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('reply_uid_task', 'text', array('label' => 'Name the project', 'required' => false, 'label_attr' => array('class' => 'control-label col-md-2'), 'attr' => array('class' => 'form-control', 'pattern' => '^[a-z0-9._%+-]+$')))
            ->add('is_public_description', 'checkbox', array('label' => 'Is public description', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
            ->add('is_billable_hours', 'checkbox', array('label' => 'Is hours billable', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
            ->add('exlude_from_global_task_list', 'checkbox', array('label' => 'Exlude from global task list', 'required' => false, 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')))
            ->add('google_drive_folder_id', 'text', array('required' => false, 'attr' => array('class' => 'form-control')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WWSC\ThalamusBundle\Entity\Project',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wwsc_thalamusbundle_project';
    }
}
