<?php

namespace DemacMedia\Bundle\ErpBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrders;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UpdateLifetimeSalesValueListener
{
    protected $containerInterface;

    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof OroErpOrders) {
            return;
        }

        $lifetimeHelper = $this->containerInterface->get('demacmedia_erp.lifetime_helper');

        $lifetimeHelper->updateLifetimeSalesValue(
            $entity->getErpaccount()->getId(),
            $entity->getWebsiteId(),
            $entity->getTotalPaid()
        );
    }
}
