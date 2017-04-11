<?php

namespace DemacMedia\Bundle\ErpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ErpAccountsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'account_number',
                'text',
                [
                    'required' => true,
                    'label'    => 'Account Number'
                ]
            )
            ->add(
                'first_name',
                'text',
                [
                    'required'    => true,
                    'label'       => 'First Name',
                ]
            )
            ->add(
                'last_name',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Last Name',
                ]
            )
            ->add(
                'email',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Email',
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
                'website_id',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Website ID',
                ]
            )
            ->add(
                'lifetime',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Lifetime Sales',
                ]
            )
            ->add(
                'lifetimeall',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Lifetime Sales All Websites',
                ]
            )
            ->add(
                'number_of_orders_all',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Number of Orders All Websites',
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
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'           => 'DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts',
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
        return 'demacmedia_erp_accounts';
    }
}
