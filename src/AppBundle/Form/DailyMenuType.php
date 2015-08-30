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
                ->add('price', 'money', array(
                      'currency' => false
                ))
                /*->add('date', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                ))*/
                ->add('enable', 'checkbox', array(
                    'required' => false,
                ))
                ->add('propositions', 'collection', array(
                    'type' => new PropositionType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
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
