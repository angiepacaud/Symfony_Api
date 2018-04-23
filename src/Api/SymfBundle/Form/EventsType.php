<?php

namespace Api\SymfBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('name')
            ->add('referrer')
            ->add('createdad');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
         $resolver->setDefaults(array(
            'data_class' => 'Api\SymfBundle\Entity\Events'

        ));
    }
}
