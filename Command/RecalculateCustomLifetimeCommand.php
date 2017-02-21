<?php

namespace DemacMedia\Bundle\ErpBundle\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;

class RecalculateCustomLifetimeCommand extends ContainerAwareCommand
{
    const COMMAND_NAME = 'demacmedia:oro:erp:lifetime:recalculate';
    protected $em;


    public function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Perform re-calculation of lifetime values for WebAccounts channel.');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $batchSize = 500;

        $i = 0;
        $this->getEntityManager();

		$totalAccounts = $this->getTotalAccounts();
        $firstWebAccountId = $this->findFirstWebAccountId();
        $lastWebAccountId = $this->findLastWebAccountId();

		for ($x = $firstWebAccountId; $x <= $lastWebAccountId; $x = $x + $batchSize) {
            $dql = "SELECT a FROM DemacMediaErpBundle:OroErpAccounts AS a";
            $query = $this->em->createQuery($dql)
                ->setFirstResult($x)
                ->setMaxResults($batchSize);

            $iterableResult = $query->iterate();

            foreach ($iterableResult as $row) {
                $deaEntity = $row[0];
                $customerId = $deaEntity->getId();
                $customerEmail = strtolower($deaEntity->getOriginalEmail());
                $deaContact = $deaEntity->getContact();
                $firstName = $deaEntity->getFirstName();
                $lastName = $deaEntity->getLastName();

                $output->writeln(
                    sprintf('<comment>Processing %d of %d - <info>%.2f%%</info> - %s</comment> ',
                        ($i + 1),
                        $totalAccounts,
                        $this->getPercentage($i, $totalAccounts),
                        $customerEmail
                    )
                );

                /*
                ********************************************
                    Call method adding it to JobQueue()
                ********************************************

                
                    
                */

                $i++;
            }

            if (($i > 1) && ($i % $batchSize) === 0) {
                $this->em->flush(); // Executes all updates.
                $this->em->clear(); // Detaches all objects from Doctrine!
            }
        }
    }


    protected function calculateCustomerLifetime(EntityManager $em, $erpaccount)
    {
        /** @var OroErpAccounts $webaccountsRepo */
        $webaccountsRepo = $em->getRepository('DemacMediaErpBundle:OroErpAccounts');

        // $lifetimeValue = $webaccountsRepo->calculateLifetimeValue($erpaccount);
        // return $lifetimeValue;

        return true;
    }



/************* PRIVATE METHODS ***********************/


    private function findFirstWebAccountId() {
        $query = $this->em->createQueryBuilder()
            ->select('a.id')
            ->from('DemacMediaErpBundle:OroErpAccounts', 'a')
            ->setMaxResults( 1 )
            ->orderBy('a.id', 'ASC')
            ->getQuery();
        return $query->getSingleScalarResult();
    }


    private function findLastWebAccountId() {
        $query = $this->em->createQueryBuilder()
            ->select('a.id')
            ->from('DemacMediaErpBundle:OroErpAccounts', 'a')
            ->setMaxResults( 1 )
            ->orderBy('a.id', 'DESC')
            ->getQuery();
        return $query->getSingleScalarResult();
    }


	private function getTotalAccounts() {
		$query = $this->em->createQueryBuilder()
				->select('COUNT(f.id)')
				->from('DemacMediaErpBundle:OroErpAccounts', 'f')
				->getQuery();
		return $query->getSingleScalarResult();
	}


    private function getPercentage($currentItem, $total) {
        return round(
            (($currentItem + 1) * 100)/$total,
            2 /* Precision */
        );
    }


    private function getEntityManager() {
        if (!$this->em) {
            $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        }
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        return $this->em;
    }
}