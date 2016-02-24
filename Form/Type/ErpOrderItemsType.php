<?php

namespace DemacMedia\Bundle\ErpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ErpOrderItemsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'invno',
                'text',
                [
                    'required' => true,
                    'label'    => 'Invno'
                ]
            )
            ->add(
                'custno',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Custno',
                ]
            )
            ->add(
                'invdate',
                'oro_datetime',
                [
                    'required'    => false,
                    'label'       => 'Invdate',
                ]
            )
            ->add(
                'item',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Item',
                ]
            )
            ->add(
                'descrip',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Descrip',
                ]
            )
            ->add(
                'taxrate',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Tax Rate',
                ]
            )
            ->add(
                'cost',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Cost',
                ]
            )
            ->add(
                'price',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Price',
                ]
            )
            ->add(
                'qtyord',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Qty Ord',
                ]
            )
            ->add(
                'qtyshp',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Qty Ord',
                ]
            )
            ->add(
                'qtyord',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Qty Ord',
                ]
            )
            ->add(
                'qtyshp',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Qty shp',
                ]
            )
            ->add(
                'extprice',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ext price',
                ]
            )
            ->add(
                'ponum',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ponum',
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'           => 'DemacMedia\Bundle\ErpBundle\Entity\OroErpOrderItems',
                'csrf_protection'      => false,
                'cascade_validation'   => false,
                'extra_fields_message' => 'EXTRA FIELDS DETECTED! "{{ extra_fields }}"',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'demacmedia_erp_orderitems';
    }
}
