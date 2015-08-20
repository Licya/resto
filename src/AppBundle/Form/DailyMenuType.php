<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DailyMenuType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', 'text')
                ->add('price', 'number')
                ->add('date', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy'
                ))
                ->add('enable', 'checkbox', array(
                    'required' => false,
                ))
                ->add('propositions', 'text', array(
                    'required' => false,
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DailyMenu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_dailymenu';
    }

}
