<?php

namespace DemacMedia\Bundle\ErpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ErpOrdersType extends AbstractType
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
                'shipvia',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Shipvia',
                ]
            )
            ->add(
                'cshipno',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Cshipno',
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
                'tax',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Tax',
                ]
            )
            ->add(
                'invamt',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Invamt',
                ]
            )
            ->add(
                'ponum',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ponum',
                ]
            )
            ->add(
                'refno',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Refno',
                ]
            )
            ->add(
                'salesrep',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Salesrep',
                ]
            )
            ->add(
                'status',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Status',
                ]
            )
            ->add(
                'shipname',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Name',
                ]
            )
            ->add(
                'shipcontact',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Contact',
                ]
            )
            ->add(
                'shipcontactphone',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Contact Phone',
                ]
            )
            ->add(
                'shipaddr1',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Addr1',
                ]
            )
            ->add(
                'shipaddr2',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Addr2',
                ]
            )
            ->add(
                'shipcity',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship City',
                ]
            )
            ->add(
                'shipstate',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship State',
                ]
            )
            ->add(
                'shipzip',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Zip',
                ]
            )
            ->add(
                'shipcountry',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Country',
                ]
            )
            ->add(
                'vendorno',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Vendor',
                ]
            )
            ->add(
                'freight',
                'text',
                [
                    'required'    => false,
                    'label'       => 'freight',
                ]
            )
            ->add(
                'dateord',
                'oro_datetime',
                [
                    'required'    => false,
                    'label'       => 'dateord',
                ]
            )
            ->add(
                'estshpdate',
                'oro_datetime',
                [
                    'required'    => false,
                    'label'       => 'estshpdate',
                ]
            )
            ->add(
                'shipdate',
                'oro_datetime',
                [
                    'required'    => false,
                    'label'       => 'shipdate',
                ]
            )
            ->add(
                'created',
                'oro_datetime',
                [
                    'required'    => false,
                    'label'       => 'Created At',
                ]
            )
            ->add(
                'updated',
                'oro_datetime',
                [
                    'required'    => false,
                    'label'       => 'Updated At',
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
                'data_class'           => 'DemacMedia\Bundle\ErpBundle\Entity\OroErpOrders',
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
        return 'demacmedia_erp_orders';
    }
}
