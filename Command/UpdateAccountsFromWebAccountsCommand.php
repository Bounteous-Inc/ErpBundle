<?php

namespace DemacMedia\Bundle\ErpBundle\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use OroCRM\Bundle\AccountBundle\Entity\Account;
use OroCRM\Bundle\ContactBundle\Entity\Contact;
use OroCRM\Bundle\ContactBundle\Entity\ContactEmail;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;

class UpdateAccountsFromWebAccountsCommand extends ContainerAwareCommand
{
    const COMMAND_NAME = 'demacmedia:oro:erp:update-oro-accounts';
    protected $em;
    protected $source;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Updates OroAccounts based on all integrated WebAccounts.')
            ->addArgument(
                'batch_size',
                InputArgument::OPTIONAL,
                'Default value is 100. So you can change to more or less.'
            )
            ->setHelp("For every WebAccounts, Oro must create an OroAccount. This command helps to keep both entities synchronized.");
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $batchSize = 500;

        if ($input->getArgument('batch_size')) {
        	$batchSize = $input->getArgument('batch_size');
        }

        $i = 0;
        $this->getEntityManager();
        $this->findInstoreSource();

		$totalAccounts = $this->getTotalAccounts();
        $firstWebAccountId = $this->findFirstWebAccountId();
        $lastWebAccountId = $this->findLastWebAccountId();

		for ($x = $firstWebAccountId; $x <= $lastWebAccountId; $x = $x + $batchSize) {
            // $output->writeln('<question>' .$x. ' - ' .$batchSize. '</question>');

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

                $output->write(
                    sprintf('<comment>Processing %d of %d - <info>%.2f%%</info> - %s</comment> ',
                        ($i + 1),
                        $totalAccounts,
                        $this->getPercentage($i, $totalAccounts),
                        $customerEmail
                    )
                );

                $oroContact = $this->getOroContact($customerEmail);
                if ($oroContact) {
                    $oroAccount = $this->getOroAccount($oroContact);
                } else {
                    $oroAccount = null;
                }

                if (!$oroContact && !$oroAccount) {
                    $this->deleteContactIfExist($customerEmail, $deaEntity);
                    $contact = $this->createOroContact($customerEmail, $firstName, $lastName, $deaEntity);
                    $account = $this->createOroAccount($contact);
                    $this->updateDeaAccountContact($deaEntity, $contact, $account);
                    $output->write(' - <info> [FIXED: ACCOUNT CREATED]</info>');
                    $oroAccount = $account;
                }

                if (!$oroAccount) {
                    $this->deleteContactIfExist($customerEmail, $deaEntity);
                    $contact = $this->createOroContact($customerEmail, $firstName, $lastName, $deaEntity);
                    $account = $this->createOroAccount($contact);
                    $this->updateDeaAccountContact($deaEntity, $contact, $account);
                    $output->write(' - <info> [FIXED: ACCOUNT CREATED]</info>');

                } else {

                    if (null == $deaEntity->getAccount() || null == $deaEntity->getContact()) {
                        $this->updateDeaAccountContact($deaEntity, $oroAccount->getDefaultContact(), $oroAccount);
                    } else {

                        $deaContactId = $deaEntity->getContact()->getId();
                        $oroContactId = $oroAccount->getDefaultContact()->getId();
                        $deaAccountId = $deaEntity->getAccount()->getId();
                        $oroAccountId = $oroAccount->getId();

                        if ($deaContactId != $oroContactId || $deaAccountId != $oroAccountId) {
                            $this->updateDeaAccountContact($deaEntity, $oroAccount->getDefaultContact(), $oroAccount);
                            $output->write(' - <info> [FIXED: CONTACT REFERENCE]</info>');
                        }
                    }
                }

                $output->writeln(' ');

                $entities_storage_deaContact[] = $deaContact;
                $entities_storage_deaEntity[] = $deaContact;
                $entities_storage_oroAccount[] = $deaContact;
                $entities_storage_oroContact[] = $deaContact;


                if (($i > 1) && ($i % $batchSize) === 0) {

                    $this->em->flush(); // Executes all updates.
                    $this->em->clear(); // Detaches all objects from Doctrine!

                    foreach($entities_storage_deaContact as $entity) {
                        if (null != $entity) {
                            $this->em->detach($entity);
                        }
                    }
                    foreach($entities_storage_deaEntity as $entity) {
                        if (null != $entity) {
                            $this->em->detach($entity);
                        }
                    }
                    foreach($entities_storage_oroAccount as $entity) {
                        if (null != $entity) {
                            $this->em->detach($entity);
                        }
                    }
                    foreach($entities_storage_oroContact as $entity) {
                        if (null != $entity) {
                            $this->em->detach($entity);
                        }
                    }

                        unset($lastName);
                        unset($firstName);
                        unset($customerId);
                        unset($customerEmail);
                        unset($deaAccountId);
                        unset($oroAccountId);
                        unset($oroContactId);
                        unset($deaContact);
                        unset($deaEntity);
                        unset($oroAccount);
                        unset($oroContact);

                    unset($entities_storage_deaEntity);
                    unset($entities_storage_deaContact);
                    unset($entities_storage_oroAccount);
                    unset($entities_storage_oroContact);

                    gc_enable();
                    gc_collect_cycles();
                    $output->writeln('<question>Cleaning Memory!</question>');
                }
                ++$i;
            }
            $this->em->flush();
            $this->em->clear();
            gc_enable();
            gc_collect_cycles();
        }
    }


    private function updateDeaAccountContact($deaEntity, $contact, $account) {
        $result = false;

        $entity = $this->em->getRepository('DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts')
            ->find($deaEntity->getId());

        if ($entity !== null) {
            $entity->setAccount($account);
            $entity->setContact($contact);
            $this->em->persist($entity);
            $this->em->flush();
            $result = true;
        }

        return $result;
    }


    private function deleteContactIfExist($customerEmail, $deaEntity) {
        $result = false;
        $entity = $this->em->getRepository('OroCRM\Bundle\ContactBundle\Entity\Contact')
            ->findOneBy([
                'email' => $customerEmail
            ]);

        if ($entity !== null) {
            if (null == $deaEntity->getContact()) {
                $deaEntity->setAccount(null);
                $this->em->persist($deaEntity);
                $this->em->flush();
            } else {
                if ($deaEntity->getContact()->getId() == $entity->getId()) {
                    $deaEntity->setAccount(null);
                    $deaEntity->setContact(null);
                    $this->em->persist($deaEntity);
                    $this->em->flush();
                }
            }


            $this->em->remove($entity);
            $this->em->flush();
            $result = true;
        }
        return $result;
    }

    private function createOroContact($customerEmail, $firstName, $lastName, $deaObject) {
        $contact = new Contact();
        $email = new ContactEmail($customerEmail);
        $contact->addEmail($email);
        $contact->setEmail($customerEmail);
        $contact->setPrimaryEmail($email);
        $contact->setFirstName($firstName);
        $contact->setLastName($lastName);
        $contact->setSource($this->source);
        $contact->setOwner($deaObject->getOwner());
        $contact->setOrganization($deaObject->getOrganization());
        // $contact->setDescription($deaObject->getWebsiteId());
        $this->em->persist($contact);
        $this->em->flush();

        return $contact;
    }


    private function createOroAccount($contact) {
        $account = new Account();
        $account->addContact($contact);
        $account->setDefaultContact($contact);
        $account->setName(
            sprintf("%s %s",
                $contact->getFirstName(),
                $contact->getLastName()
            )
        );
        $account->setOwner($contact->getOwner());
        $account->setOrganization($contact->getOrganization());
        $this->em->persist($account);
        $this->em->flush();

        return $account;
    }


    private function findInstoreSource(){
        $source = null;
        $entity = $this->em->getRepository('OroCRM\Bundle\ContactBundle\Entity\Source')
            ->findOneBy([
                'name' => 'instore'
            ]);
        if ($entity !== null) {
            $source = $entity;
        }
        $this->source = $source;
    }

    private function getOroContact($deaContactEmail) {
        $contact = null;
        $emailEntity = $this->em->getRepository('OroCRM\Bundle\ContactBundle\Entity\Contact')
            ->findOneBy([
                'email' => $deaContactEmail
            ]);
        if ($emailEntity !== null) {
            $contact = $emailEntity;
        }
        return $contact;
    }


    private function getOroAccount($contact) {
        $account = null;
        $entity = $this->em->getRepository('OroCRM\Bundle\AccountBundle\Entity\Account')
            ->findOneBy([
                'defaultContact' => $contact->getId()
            ]);
        if ($entity !== null) {
            $account = $entity;
        }
        return $account;
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


    private function getMemory() {
        return round(memory_get_usage(true)/1048576);
    }


    /**
     * @return EntityManagerInterface
     */
    private function getEntityManager()
    {
        if (!$this->em) {
            $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        }
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        return $this->em;
    }
}
