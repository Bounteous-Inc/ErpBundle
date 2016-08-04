<?php

namespace DemacMedia\Bundle\ErpBundle\Command;

use Doctrine\ORM\EntityManager;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrders;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrderItems;

class RecalculateCustomLifetimeCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        parent::configure();

        $this
            ->setName('demacmedia:oro:erp:lifetime:recalculate')
            ->setDescription('Perform re-calculation of lifetime values for WebAccounts channel.');
    }

    /**
     * @param EntityManager $em
     * @param OroErpAccounts $erpaccount
     *
     * @return float
     */
    protected function calculateCustomerLifetime(EntityManager $em, $erpaccount)
    {
        /** @var OroErpAccounts $webaccountsRepo */
        $webaccountsRepo = $em->getRepository('DemacMediaErpBundle:OroErpAccounts');

        // $lifetimeValue = $webaccountsRepo->calculateLifetimeValue($erpaccount);
        // return $lifetimeValue;

        return true;
    }
}