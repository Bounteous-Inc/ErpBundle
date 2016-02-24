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
                'custno',
                'text',
                [
                    'required' => true,
                    'label'    => 'Custno'
                ]
            )
            ->add(
                'company',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Company',
                ]
            )
            ->add(
                'contactname',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Contact Name',
                ]
            )
            ->add(
                'title',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Title',
                ]
            )
            ->add(
                'address1',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Address1',
                ]
            )
            ->add(
                'address2',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Address2',
                ]
            )
            ->add(
                'city',
                'text',
                [
                    'required'    => true,
                    'label'       => 'City',
                ]
            )
            ->add(
                'addrstate',
                'text',
                [
                    'required'    => false,
                    'label'       => 'State',
                ]
            )
            ->add(
                'zip',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Zip',
                ]
            )
            ->add(
                'country',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Country',
                ]
            )
            ->add(
                'phone',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Phone',
                ]
            )
            ->add(
                'phone2',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Phone2',
                ]
            )
            ->add(
                'source',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Source',
                ]
            )
            ->add(
                'type',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Type',
                ]
            )
            ->add(
                'email',
                'email',
                [
                    'required'    => false,
                    'label'       => 'Email',
                ]
            )
            ->add(
                'custmemo',
                'textarea',
                [
                    'required'    => false,
                    'label'       => 'Custmemo',
                ]
            )
            ->add(
                'url',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Url',
                ]
            )
            ->add(
                'salesrep',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Sales Representative',
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
