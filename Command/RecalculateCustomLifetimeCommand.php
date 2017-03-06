<?php

namespace DemacMedia\Bundle\ErpBundle\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Oro\Bundle\CronBundle\Command\CronCommandInterface;

use JMS\JobQueueBundle\Entity\Job;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;

class RecalculateCustomLifetimeCommand extends ContainerAwareCommand implements CronCommandInterface
{
    const COMMAND_NAME = 'oro:cron:demacmedia:erp:lifetime:recalculate';
    const MAX_TIME_EXECUTION = 120; /* Maximum execution time in seconds. 120 = 2 minutes */
    const LOCK_FILENAME = 'lifetime_running.lock';
    protected $em;
    protected $x;
    protected $startedAt;

    public function getDefaultDefinition()
    {
        return '*/1 * * * *';
    }


    public function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->addArgument('execution_type', InputArgument::OPTIONAL, 'Is it Cron or Manual execution? (DONT CHANGE. INTERNAL PARAMETER)')
            ->setDescription('Perform re-calculation of lifetime values for WebAccounts channel.');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setStartedAt();
        $batchSize = 100;

        if ($input->getArgument('execution_type') == 'manualrun'){
            // Manual execution
            if (!file_exists(sys_get_temp_dir(). '/' .self::LOCK_FILENAME)) {
                $this->createRunningLock(); // Creates running.lock
            }
        } else {
            // Automatic execution
            if (!file_exists(sys_get_temp_dir(). '/' .self::LOCK_FILENAME)) {
                return 0;
                // If wasn't started manually, LOCK_FILENAME doesn't exist.
                // That means, exit from this execution right now!
            }
        }

        $i = $this->getX();
        $this->getEntityManager();
		$totalAccounts = $this->getTotalAccounts();
        $firstWebAccountId = $this->findFirstWebAccountId();
        $lastWebAccountId = $this->findLastWebAccountId();

		for ($x = $this->getX(); $x <= $lastWebAccountId; $x = $x + $batchSize) {
		    $dql = "SELECT a FROM DemacMediaErpBundle:OroErpAccounts AS a ORDER BY a.id DESC";
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
                    Call method adding it to Job Queue
                ********************************************
                */
                $this->addFixLifetimeToJobQueue($deaEntity);


                ++$i;
            }

            if (($i > 1) && ($i % $batchSize) === 0) {
                $this->em->flush(); // Executes all updates.
                $this->em->clear(); // Detaches all objects from Doctrine!
                $this->setX($i); // Saves the last batch executed to LOCK_FILENAME

                if (time() >= ($this->startedAt + self::MAX_TIME_EXECUTION)) {
                    $output->writeln('Maximum time of execution reached. Exiting command.');
                    exit;
                }
            }
        }

        // Finished execution!
        $output->writeln('Finished. Removing LOCK_FILENAME and sending email...');
        unlink(sys_get_temp_dir(). '/' .self::LOCK_FILENAME); // Remove lifetime_running.lock
        $output->writeln('Done.');
    }


/************* PRIVATE METHODS ***********************/

    private function setX($x)
    {
        $fp = fopen(sys_get_temp_dir(). '/' .self::LOCK_FILENAME, 'w+');
        fputs($fp, $x);
        fclose($fp);
        $this->x = $x;
    }

    private function getX()
    {
        if (file_exists(sys_get_temp_dir(). '/' .self::LOCK_FILENAME)) {
            $fp = fopen(sys_get_temp_dir(). '/' .self::LOCK_FILENAME, 'r');
            $x = fread($fp, 32);
            fclose($fp);
            return $x;
        }
        return $this->x;
    }

    private function createRunningLock()
    {
        $this->x = 0;
        $fp = fopen(sys_get_temp_dir(). '/' .self::LOCK_FILENAME, 'w+');
        fputs($fp, $this->x);
        fclose($fp);
    }

    private function setStartedAt()
    {
        $this->startedAt = time();
    }

    private function addFixLifetimeToJobQueue(OroErpAccounts $entity)
    {
        if (!$entity instanceof OroErpAccounts) {
            return;
        }

        $entity->getAccount();

        $job = new Job('demacmedia:oro:erp:lifetime:update', [
            $entity->getId(),
            $entity->getOriginalEmail(),
            0
        ],
        true,
        Job::DEFAULT_QUEUE,
        Job::PRIORITY_LOW
        );

        $this->em->persist($job);
    }


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
