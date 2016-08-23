<?php

namespace DemacMedia\Bundle\ErpBundle\Command;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateLifetimeValueCommand extends Command
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
            ->addArgument(
                'erpaccount-id',
                InputArgument::REQUIRED,
                'ErpAccountID is the OroAccount ID'
            )
            ->addArgument(
                'original-email',
                InputArgument::REQUIRED,
                'Original and Unique Email for this user'
            )
            ->addArgument(
                'total-paid',
                InputArgument::REQUIRED,
                'Total Paid float value coming from Orders (total paid) field'
            )
            ->setHelp("This command allows you to update of lifetime sales values for WebAccounts channel.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lifetimeHelper = $this->get('demacmedia_erp.lifetime_helper');

        $lifetimeHelper->updateLifetimeSalesValue(
            $input->getArgument('erpaccount-id'),
            $input->getArgument('original-email'),
            $input->getArgument('total-paid')
        );
    }
}
