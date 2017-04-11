<?php

namespace DemacMedia\Bundle\ErpBundle\Entity\Helper;

use Doctrine\ORM\EntityManager;
use OroCRM\Bundle\ChannelBundle\Entity\LifetimeValueHistory;


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
    public function updateLifetimeSalesValue($accountId, $originalEmail, $totalPaid=0) {
        if (!is_numeric($accountId)){
            return false;
        }

        $lifetimeSalesValue = $this->getLifetimeSalesValue($accountId, $totalPaid);

        $this->setLifetimeSalesValue($accountId, $lifetimeSalesValue);
        $lifetimeAllSalesValue = $this->getLifetimeAllSalesValue($originalEmail);
        $this->setLifetimeAllSalesValue(
            $originalEmail,
            $lifetimeAllSalesValue
        );
        $this->setOroLifetimeValueHistory($accountId, $lifetimeAllSalesValue);
        $this->setNumberOfOrdersInAccounts($accountId);
        $this->setNumberOfOrdersAllInAccounts($originalEmail);

        return $lifetimeSalesValue;
    }

    /**
     * @param $accountId
     *
     * @return float
     */
    public function getLifetimeSalesValue($accountId, $totalPaid) {
        if (!is_numeric($accountId)){
            return false;
        }

        $qb = $this->em
            ->getRepository('DemacMediaErpBundle:OroErpOrders')
            ->createQueryBuilder('o');

        $qb->select('SUM(o.totalPaid)');
        $qb->where('o.erpaccount = :account_id');
        $qb->setParameters([
            'account_id' => $accountId
        ]);

        $lifetimeSales = (float)$qb->getQuery()->getSingleScalarResult();

        if ($lifetimeSales < 1 || $lifetimeSales == null) {
            $lifetimeSales = $totalPaid;
        }

        return $lifetimeSales;
    }


    public function getLifetimeAllSalesValue($originalEmail) {
        $qb = $this->em
            ->getRepository('DemacMediaErpBundle:OroErpOrders')
            ->createQueryBuilder('o');

        $qb->select('SUM(o.totalPaid)');
        $qb->where('o.originalEmail = :original_email');
        $qb->setParameters([
            'original_email' => $originalEmail
        ]);

        return (float)$qb->getQuery()->getSingleScalarResult();
    }

    public function setLifetimeSalesValue($accountId, $lifetimeSalesValue) {
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
            return $qb->getQuery()->getSingleScalarResult();
        }
    }

    public function setLifetimeAllSalesValue($originalEmail, $lifetimeAllSalesValue) {
        if (is_float($lifetimeAllSalesValue)) {
            $qb = $this->em
                ->getRepository('DemacMediaErpBundle:OroErpAccounts')
                ->createQueryBuilder('a');
            $qb->update('DemacMediaErpBundle:OroErpAccounts', 'a');
            $qb->set('a.lifetimeall', $lifetimeAllSalesValue);
            $qb->where('a.originalEmail = :original_email');
            $qb->setParameters([
                'original_email' => $originalEmail
            ]);
            return $qb->getQuery()->getSingleScalarResult();
        }
    }

    public function setOroLifetimeValueHistory($accountId, $lifetimeSalesValue) {
        if ($lifetimeSalesValue) {

            $erpAccount = $this->em
                ->getRepository('DemacMediaErpBundle:OroErpAccounts')
                ->find($accountId);

            $oroAccountId = $erpAccount->getAccount()->getId();

            $account = $this->em
                ->getRepository('OroCRM\Bundle\AccountBundle\Entity\Account')
                ->find($oroAccountId);

            $qb = $this->em
                ->getRepository('OroCRMChannelBundle:LifetimeValueHistory')
                ->createQueryBuilder('h');
            $qb->update('OroCRMChannelBundle:LifetimeValueHistory', 'h');
            $qb->set('h.status', '0');
            $qb->where('h.account = :account_id');
            $qb->setParameters([
                'account_id' => $oroAccountId
            ]);
            $qb->getQuery()->execute();

            $dataChannel = $this->em
                ->getRepository('OroCRM\Bundle\ChannelBundle\Entity\Channel')
                ->find(1);

            $entity = new LifetimeValueHistory();
            $entity->setStatus(1);
            $entity->setAccount($account);
            $entity->setDataChannel($dataChannel);
            $entity->setAmount($lifetimeSalesValue);

            $this->em->persist($entity);
            $this->em->flush();

            return true;
        }
    }

    public function setNumberOfOrdersInAccounts($accountId) {
        $qb = $this->em
            ->getRepository('DemacMediaErpBundle:OroErpOrders')
            ->createQueryBuilder('o');
        $qb->select('COUNT(o.id)');
        $qb->where('o.erpaccount = :account_id');
        $qb->setParameters([
            'account_id' => $accountId
        ]);

        $numberOfOrders = (int)$qb->getQuery()->getSingleScalarResult();

        $qb = $this->em
            ->getRepository('DemacMediaErpBundle:OroErpAccounts')
            ->createQueryBuilder('a');
        $qb->update('DemacMediaErpBundle:OroErpAccounts', 'a');
        $qb->set('a.numberOfOrders', ':number_of_orders');
        $qb->where('a.id = :account_id');
        $qb->setParameters([
            'account_id' => $accountId,
            'number_of_orders' => $numberOfOrders
        ]);
        $qb->getQuery()->setMaxResults(1);
        $qb->getQuery()->execute();
    }


/*
    This method sets Quantity of orders this email has across all websites.
*/
    public function setNumberOfOrdersAllInAccounts($originalEmail) {
        
        $numberOfOrders = calculateNumberOfOrdersAll($originalEmail);

        $qb = $this->em
            ->getRepository('DemacMediaErpBundle:OroErpAccounts')
            ->createQueryBuilder('a');
        $qb->update('DemacMediaErpBundle:OroErpAccounts', 'a');
        $qb->set('a.numberOfOrdersAll', ':number_of_orders_all');
        $qb->where('a.originalEmail = :original_email');
        $qb->setParameters([
            'original_email' => $originalEmail,
            'number_of_orders_all' => $numberOfOrders
        ]);
        // No more max results since I could have more than 1 accounts with the same email
        // $qb->getQuery()->setMaxResults(1);
        $qb->getQuery()->execute();
    }

    public function getNumberOfOrdersAll($originalEmail) {
        $qb = $this->em
            ->getRepository('DemacMediaErpBundle:OroErpAccounts')
            ->createQueryBuilder('a');
        $qb->select('a.numberOfOrdersAll');
        $qb->where('a.originalEmail = :original_email');
        $qb->setParameters([
            'original_email' => $originalEmail
        ]);

        return (int)$qb->getQuery()->getSingleScalarResult();
    }

    public function calculateNumberOfOrdersAll($originalEmail) {
        $qb = $this->em
            ->getRepository('DemacMediaErpBundle:OroErpOrders')
            ->createQueryBuilder('o');
        $qb->select('COUNT(o.id)');
        $qb->where('o.originalEmail = :original_email');
        $qb->setParameters([
            'original_email' => $originalEmail
        ]);

        return (int)$qb->getQuery()->getSingleScalarResult();
    }
}
