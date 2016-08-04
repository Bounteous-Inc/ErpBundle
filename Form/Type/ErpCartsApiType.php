<?php
namespace DemacMedia\Bundle\ErpBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Oro\Bundle\SoapBundle\Form\EventListener\PatchSubscriber;

class ErpCartsApiType extends ErpCartsType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->addEventSubscriber(new PatchSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                'data_class'           => 'DemacMedia\Bundle\ErpBundle\Entity\OroErpCarts',
                'csrf_protection'      => false,
                'cascade_validation'   => false,
                'extra_fields_message' => 'EXTRA FIELDS DETECTED! "{{ extra_fields }}"',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'demacmedia_erp_carts_api';
    }
}
