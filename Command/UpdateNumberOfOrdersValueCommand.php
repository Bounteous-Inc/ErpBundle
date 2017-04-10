<?php

namespace DemacMedia\Bundle\ErpBundle\Command;

use Doctrine\ORM\EntityManager;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateNumberOfOrdersValueCommand extends ContainerAwareCommand
{
    const COMMAND_NAME = 'demacmedia:oro:erp:number-of-orders:update';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Perform update of Number of Orders for a WebAccount.')
            ->addArgument('original_email', InputArgument::REQUIRED, '"foo@example.org" Original and Unique Email for this user')
            ->setHelp("This command allows you to update of lifetime sales values for WebAccounts channel.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lifetimeHelper = $this
            ->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('demacmedia_erp.lifetime_helper');

        $lifetimeHelper->setNumberOfOrdersAllInAccounts(
            $input->getArgument('original_email')
        );
    }
}
