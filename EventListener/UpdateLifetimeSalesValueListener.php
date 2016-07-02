<?php

namespace DemacMedia\Bundle\ErpBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrders;

class UpdateLifetimeSalesValueListener
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof OroErpOrders) {
            return;
        }

        $lifetimeHelper = $this->get('demacmedia_erp.lifetime_helper');
        $lifetimeHelper->updateLifetimeSalesValue($entity->getId());
    }
}
