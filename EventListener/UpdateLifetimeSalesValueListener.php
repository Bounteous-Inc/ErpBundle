<?php

namespace DemacMedia\Bundle\ErpBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\JobQueueBundle\Entity\Job;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrders;

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

        $job = new Job('demacmedia:oro:erp:lifetime:update', [
            sprintf('--erpaccount-id=%d', $entity->getErpaccount()->getId()),
            sprintf('--original-email=%s', $entity->getOriginalEmail()),
            sprintf('--total-paid=%s', $entity->getTotalPaid())
        ]);
        $em = $this->containerInterface->get('doctrine')->getManagerForClass('JMSJobQueueBundle:Job');
        $em->persist($job);
        $em->flush();
    }
}
