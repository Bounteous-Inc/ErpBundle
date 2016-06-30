<?php

namespace DemacMedia\Bundle\ErpBundle\Entity\Helper;

use Doctrine\ORM\EntityManager;

class OroErpAccountsHelper
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param null $qte
     *
     * @return array
     */
    public function updateLifetimeSalesValue($accountId) {
        if (!is_numeric($accountId)){
            return false;
        }

        $qb = $this->em
            ->getRepository('DemacMediaErpBundle:OroErpOrders')
            ->createQueryBuilder('o');

        $qb->select('SUM(o.totalPaid)');
        $qb->innerJoin('o.erpaccount', 'a');
        $qb->where('a.id = :account_id');
        $qb->setParameters([
            'account_id' => $accountId
        ]);

        $lifetimeSalesValue = (float)$qb->getQuery()->getSingleScalarResult();

        if (is_float($lifetimeSalesValue)) {
            $qb = $this->em
                ->getRepository('DemacMediaErpBundle:OroErpAccounts')
                ->createQueryBuilder('a');
            $qb->update('DemacMediaErpBundle:OroErpAccounts', 'a');
            $qb->set('a.lifetime', $lifetimeSalesValue);
            $qb->where('a.id = :account_id');
            $qb->setParameters([
                'account_id' => $accountId
            ]);
            $qb->setMaxResults(1);
            $resultUpdate = $qb->getQuery()->getSingleScalarResult();

        }

        return $lifetimeSalesValue;
    }

    /**
     * @param $accountId
     *
     * @return float
     */
    public function getLifetimeSalesValue($accountId) {
        if (!is_numeric($accountId)){
            return false;
        }

        $qb = $this->em
            ->getRepository('DemacMediaErpBundle:OroErpOrders')
            ->createQueryBuilder('o');

        $qb->select('SUM(o.totalPaid)');
        $qb->innerJoin('o.erpaccount', 'a');
        $qb->where('a.id = :account_id');
        $qb->setParameters([
            'account_id' => $accountId
        ]);

        $result = (float)$qb->getQuery()->getSingleScalarResult();

        return $result;
    }
}
