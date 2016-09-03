<?php

namespace DemacMedia\Bundle\ErpBundle\Command;

use Doctrine\ORM\EntityManager;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateLifetimeValueCommand extends ContainerAwareCommand
{
    const COMMAND_NAME = 'demacmedia:oro:erp:lifetime:update';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Perform update of lifetime sales values for WebAccounts channel.')
            ->addArgument('erpaccount_id', InputArgument::REQUIRED, '"12345" ErpAccountID is the OroAccount ID')
            ->addArgument('original_email', InputArgument::REQUIRED, '"foo@example.org" Original and Unique Email for this user')
            ->addArgument('total_paid', InputArgument::REQUIRED, '"20.33" Total Paid float value coming from Orders (total paid) field')
            ->setHelp("This command allows you to update of lifetime sales values for WebAccounts channel.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lifetimeHelper = $this
            ->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('demacmedia_erp.lifetime_helper');

        $totalPaid = str_replace('$', '', $input->getArgument('total_paid'));

        $lifetimeHelper->updateLifetimeSalesValue(
            $input->getArgument('erpaccount_id'),
            $input->getArgument('original_email'),
            $totalPaid
        );
    }
}
