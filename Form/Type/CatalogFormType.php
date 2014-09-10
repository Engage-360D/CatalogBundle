<?php

/*
 * This file is part of the Engage360d Catalog Bundle
 *
 * (c) Aliocha Ryzhkov <alioch@yandex.ru>
 */

namespace Engage360d\Bundle\CatalogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatalogFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'text', array('label' => 'ID'))
            ->add('name', 'text', array('label' => 'Catalog name'))
            ->add('Add catalog', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Engage360d\Bundle\CatalogBundle\Entity\Catalog',
        ));
    }

    public function getName()
    {
        return 'engage360d_catalog';
    }
}