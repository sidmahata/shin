<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UrlType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId')
//            ->add('shortcode')
            ->add('alias')
            ->add('longurl')
            ->add('description')
            ->add('password')
            ->add('click')
            ->add('metaTitle')
            ->add('metaDescription')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Url'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_url';
    }
}
