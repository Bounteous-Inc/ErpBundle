<?php

namespace DemacMedia\Bundle\ErpBundle\Command;

use Doctrine\ORM\EntityManager;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
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
            ->addOption(
                'erpaccount-id',
                null,
                InputOption::VALUE_REQUIRED,
                'ErpAccountID is the OroAccount ID'
            )
            ->addOption(
                'original-email',
                null,
                InputOption::VALUE_REQUIRED,
                'Original and Unique Email for this user'
            )
            ->addOption(
                'total-paid',
                null,
                InputOption::VALUE_REQUIRED,
                'Total Paid float value coming from Orders (total paid) field'
            )
            ->setHelp("This command allows you to update of lifetime sales values for WebAccounts channel.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lifetimeHelper = $this
            ->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('demacmedia_erp.lifetime_helper');

        $lifetimeHelper->updateLifetimeSalesValue(
            $input->getOption('erpaccount-id'),
            $input->getOption('original-email'),
            $input->getOption('total-paid')
        );
    }
}
