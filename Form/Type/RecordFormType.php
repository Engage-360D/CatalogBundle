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

class RecordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('catalog', 'entity', array(
                'class' => 'Engage360d\Bundle\CatalogBundle\Entity\Catalog',
                'property' => 'name',
                'empty_value' => '',
                'required' => true,
            ))
            ->add('data', 'text')
            ->add('keyword', 'text', array('required' => false))
            ->add('order', 'integer', array('required' => false))
            ->add('Add record', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Engage360d\Bundle\CatalogBundle\Entity\Record',
        ));
    }

    public function getName()
    {
        return 'engage360d_catalog_record';
    }
}