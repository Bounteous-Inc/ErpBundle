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
                'original_order_id',
                'number',
                [
                    'required' => true,
                    'label'    => 'Original Order ID'
                ]
            )
            ->add(
                'original_email',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Original Email',
                ]
            )
            ->add(
                'total_paid',
                'oro_money',
                [
                    'required'    => false,
                    'label'       => 'Total Paid',
                ]
            )
            ->add(
                'created_at',
                'oro_datetime',
                [
                    'required'    => true,
                    'label'       => 'Created At',
                ]
            )
            ->add(
                'updated_at',
                'oro_datetime',
                [
                    'required'    => true,
                    'label'       => 'Updated At',
                ]
            )
            ->add(
                'bill_firstname',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Bill First Name',
                ]
            )
            ->add(
                'bill_lastname',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Bill Last Name',
                ]
            )
            ->add(
                'bill_company',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Bill Company',
                ]
            )
            ->add(
                'bill_address1',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Bill Address1',
                ]
            )
            ->add(
                'bill_address2',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Bill Address2',
                ]
            )
            ->add(
                'bill_city',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Bill City',
                ]
            )
            ->add(
                'bill_state',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Bill State',
                ]
            )
            ->add(
                'bill_zip',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Name',
                ]
            )
            ->add(
                'bill_phone',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Name',
                ]
            )
            ->add(
                'ship_firstname',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship First Name',
                ]
            )
            ->add(
                'ship_lastname',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Last Name',
                ]
            )
            ->add(
                'ship_company',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Company',
                ]
            )
            ->add(
                'ship_address1',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Address1',
                ]
            )
            ->add(
                'ship_address2',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Address2',
                ]
            )
            ->add(
                'ship_city',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship City',
                ]
            )
            ->add(
                'ship_state',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship State',
                ]
            )
            ->add(
                'ship_zip',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Zip',
                ]
            )
            ->add(
                'ship_phone',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Ship Phone',
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
