<?php

namespace DemacMedia\Bundle\ErpBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrders;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrderItems;

class ErpImporterCommand extends ContainerAwareCommand
{
    const CSV_FOLDER = 'erp-integration-csvs/';
    const COMMAND_NAME = 'demacmedia:oro:erp:import';

    protected $csvFile;
    protected $csvPath;
    protected $entityManager;
    protected $progress;
    protected $lines;
    protected $myLogger;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Import a Erp .csv using command line')
            ->addOption(
                'current-user',
                null,
                InputOption::VALUE_REQUIRED,
                'current-user is required'
            )
            ->addOption(
                'current-organization',
                null,
                InputOption::VALUE_REQUIRED,
                'current-organization is required'
            )
            ->addOption(
                'csvfile',
                null,
                InputOption::VALUE_REQUIRED,
                '.csv file path is required',
                'csv'
            );

        $this->myLogger = new Logger('importError');
        $this->myLogger->pushHandler(new StreamHandler(__DIR__.'/erp-error.log', Logger::WARNING));
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new OutputFormatterStyle('white', 'cyan', array('blink'));
        $output->getFormatter()->setStyle('demac', $style);

        $csvfile = $input->getOption('csvfile');
        $currentUser = $input->getOption('current-user');
        $currentOrganization = $input->getOption('current-organization');

        $errorMessage = sprintf(
            '<comment>Use: %s --file=file.csv --current-user=17 --current-organization=1</comment>',
            self::COMMAND_NAME
        );

        if (!$csvfile || !$currentUser || !$currentOrganization) {
            $output->writeln(
                $errorMessage
            );
        }

        $this->showDemacMediaHeader($output);

        $output->writeln(
            sprintf(
                '<comment>Importing .csv: <info>%s</info></comment>',
                $csvfile
            )
        );

        $this->checkIfCsvExist($csvfile, $output);

        $this->progress = $this->getHelper('progress');
        $this->lines = $this->getLines($this->csvPath);
        $this->progress->start($output, $this->lines);

        if (($handle = fopen($this->csvPath, "r")) !== false) {
            $line = 0;
            $header = '';

            while (($data = fgetcsv($handle)) !== false) {
                if (0 == $line) {
                    $header = $data;

                    if (in_array('invdte', $header)) {
                        $header = array_replace(
                            $header,
                            array_fill_keys(
                                array_keys($header, 'invdte'),
                                'invdate'
                            )
                        );
                    }

                    $header = array_flip($header);
                } else {
                    if ($this->isAccountsParser($header)) {
                        $this->updateAccount($header, $data);
                    }

                    if ($this->isOrdersParser($header)) {
                        $this->updateOrders($header, $data);
                    }

                    if ($this->isOrderItemsParser($header)) {
                        $this->updateOrderItems($header, $data);
                    }
                }

                $line++;

                $this->progress->advance();
            }
            fclose($handle);
        }

        $this->progress->finish();
        $output->writeln('<info>Success!</info>');
        $output->writeln('');
    }


    protected function isAccountsParser($header)
    {
        $arrayAccounts = [
            'custno',
            'company',
            'contact',
            'title',
            'address1',
            'address2',
            'city',
            'addrstate',
            'zip',
            'country',
            'phone',
            'phone2',
            'source',
            'type',
            'email',
            'custmemo',
            'url'
        ];

        if (sizeof(array_diff(array_flip($header), $arrayAccounts)) < 1) {
            return true;
        }
        return false;
    }

    protected function isOrdersParser($header)
    {
        $arrayOrders = [
            'invno',
            'custno',
            'invdate',
            'shipvia',
            'cshipno',
            'taxrate',
            'tax',
            'invamt',
            'ponum',
            'refno'
        ];

        if (sizeof(array_diff(array_flip($header), $arrayOrders)) < 1) {
            return true;
        }
        return false;
    }


    protected function isOrderItemsParser($header)
    {
        $arrayOrderItems = [
            'invno',
            'custno',
            'item',
            'descrip',
            'taxrate',
            'cost',
            'price',
            'qtyord',
            'qtyshp',
            'extprice',
            'invdate'
        ];

        if (sizeof(array_diff(array_flip($header), $arrayOrderItems)) < 1) {
            return true;
        }
        return false;
    }

    protected function updateAccount($header, $data)
    {
        $entity = null;
        $update = false;

        if (!$data[$header['contact']] && $data[$header['company']]) {
            $data[$header['contact']] = $data[$header['company']];
        }

        $data[$header['city']] = (!$data[$header['city']])? 'null': $data[$header['city']];
        $data[$header['contact']] = (!$data[$header['contact']])? 'null': $data[$header['contact']];
        $data[$header['phone']] = (!$data[$header['phone']])? 'null': $data[$header['phone']];


        // Validating required fields
        if (!$data[$header['custno']]) {
            $msgError = sprintf(
                " [ACCOUNTS] - Required field missing. 'custno': [%s]",
                $data[$header['custno']]
            );

            $this->myLogger->addWarning(
                $msgError
            );
            echo $msgError. PHP_EOL;

            return false;
        }

        if ($data[$header['custno']] < 1) {
            echo "\n----------------------------------------------> No custno < 1 \n";
            return false;
        }

        if (is_numeric($data[$header['custno']])) {
            $data[$header['custno']] = (int) $data[$header['custno']];
        }

        if ("web" === strtolower($data[$header['source']])) {
            return false;
        }

        $erpAccounts = $this->getEntityManager()
            ->getRepository('DemacMediaErpBundle:OroErpAccounts')->findOneBy([
            'custno' => $data[$header['custno']]
            ]);

        if (!$erpAccounts) {
            $this->getEntityManager()->clear();
            $erpAccounts = new OroErpAccounts();
        } else {
            $entity = $erpAccounts;
        }

        foreach ($header as $key => $value) {
            if (!isset($data[$value])) {
                echo "\n---------------------------------------> No value on line on field {$value} \n";
                return false;
            }
            $csvValue = utf8_encode($data[$value]);
            if ($data[$value]) {
                if (is_object($entity)) {
                    $getValue = call_user_func([$entity, 'get' . ucwords($key)]);
                    if ($csvValue != $getValue) {
                        call_user_func([$erpAccounts, 'set' . ucwords($key)], $csvValue);
                        $update = true;
                    }
                } else {
                    call_user_func([$erpAccounts, 'set' . ucwords($key)], $csvValue);
                }
            }
        }

        try {
            if ($update == true && is_object($entity) || !$update && !is_object($entity)) {
                $this->getEntityManager()->persist($erpAccounts);
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        } catch (\Doctrine\ORM\ORMException $e) {
            echo $e->getMessage();
        }
    }


    protected function updateOrders($header, $data)
    {
        $entity = null;
        $update = false;

        if (!$data[$header['custno']] || !$data[$header['invno']]) {
            $msgError = sprintf(
                "[ORDERS] - Required field missing. 'custno': [%s] - 'invno': [%s] - REFNO: %s",
                $data[$header['custno']],
                $data[$header['invno']],
                $data[$header['refno']]
            );

            $this->myLogger->addWarning(
                $msgError
            );
            echo " " .$msgError. PHP_EOL;

            return false;
        }

        $source = $this->getEntityManager()
            ->getRepository('DemacMediaErpBundle:OroErpAccounts')->findOneBy([
                'custno' => $data[$header['custno']]
            ]);

        if ($source !== null) {
            if ("web" === $source->getSource()) {
                $source = null;
                return false;
            }
        } else {
            return false;
        }

        if (is_numeric($data[$header['invno']])) {
            $data[$header['invno']] = (int) $data[$header['invno']];
        }

        $erpOrders = $this->getEntityManager()
            ->getRepository('DemacMediaErpBundle:OroErpOrders')->findOneBy([
                'invno' => $data[$header['invno']]
            ]);

        if (!$erpOrders) {
            $this->getEntityManager()->clear();
            $erpOrders = new OroErpOrders();
        } else {
            $entity = $erpOrders;
        }

        foreach ($header as $key => $value) {
            $csvValue = utf8_encode($data[$value]);
            if ($data[$value]) {
                if ($key == 'invdate') {
                    $csvValue = \DateTime::createFromFormat('d/m/Y H:i A', $csvValue);
                }

                if (is_object($entity)) {
                    $getValue = call_user_func([$entity, 'get' . ucwords($key)]);
                    if ($csvValue != $getValue) {
                        call_user_func([$erpOrders, 'set' . ucwords($key)], $csvValue);
                        $update = true;
                    }
                } else {
                    call_user_func([$erpOrders, 'set' . ucwords($key)], $csvValue);
                }
            }
        }


        try {
            if (($update == true && is_object($entity)) || (!$update && !is_object($entity))) {
                $this->getEntityManager()->persist($erpOrders);
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        } catch (\Doctrine\ORM\ORMException $e) {
            echo $e->getMessage();
        }
    }


    protected function updateOrderItems($header, $data)
    {
        $entity = null;
        $update = false;

        if (!$data[$header['item']] || !$data[$header['invno']]) {
            $msgError = sprintf(
                "[ORDERS_ITEMS] - Required field missing. 'item': [%s] - 'invno': [%s] - ITEM: %s - DESCRIP: %s",
                $data[$header['item']],
                $data[$header['invno']],
                $data[$header['item']],
                $data[$header['descrip']]
            );

            $this->myLogger->addWarning(
                $msgError
            );
            echo " " .$msgError. PHP_EOL;

            return false;
        }


        if (is_numeric($data[$header['invno']])) {
            $data[$header['invno']] = (int) $data[$header['invno']];
        }

        $custno = $this->getCustnoFromInvno($data[$header['invno']]);

        if ($custno) {
            $data[$header['custno']] = $custno;
        } else {
            $msgError = sprintf(
                "[ORDERS_ITEMS] - Sorry but no order with this invno: %s",
                $data[$header['invno']]
            );

            $this->myLogger->addWarning(
                $msgError
            );
            echo " " .$msgError. PHP_EOL;

            return false;
        }

        $query = $this->getContainer()->get('doctrine.orm.entity_manager')->createQuery("
            SELECT
                a.source
            FROM DemacMediaErpBundle:OroErpOrders AS o
                INNER JOIN DemacMediaErpBundle:OroErpAccounts AS a WITH a.custno = o.custno
            WHERE o.invno = :invno
        ")->setParameter('invno', $data[$header['invno']]);

        $source = $query->getOneOrNullResult();

        if (null !== $source) {
            if ("web" === $source['source']) {
                $source = null;
                return false;
            }
        } else {
            return false;
        }

        $erpOrderItems = $this->getEntityManager()
            ->getRepository('DemacMediaErpBundle:OroErpOrderItems')->findOneBy([
            'invno'  => $data[$header['invno']],
            'item'   => $data[$header['item']]
            ]);

        if (!$erpOrderItems) {
            $this->getEntityManager()->clear();
            $erpOrderItems = new OroErpOrderItems();
        } else {
            $entity = $erpOrderItems;
        }

        foreach ($header as $key => $value) {
            $csvValue = utf8_encode($data[$value]);
            if ($data[$value]) {
                if (is_object($entity)) {
                    $getValue = call_user_func([$entity, 'get' . ucwords($key)]);
                    if ($csvValue != $getValue) {
                        if ('invdate' == $key) {
                            $csvValue = new \DateTime($data[$value], new \DateTimeZone('UTC'));
                        }
                        call_user_func([$erpOrderItems, 'set' . ucwords($key)], $csvValue);
                        $update = true;
                    }
                } else {
                    call_user_func([$erpOrderItems, 'set' . ucwords($key)], $csvValue);
                }
            }
        }

        try {
            if ($update == true && is_object($entity) || !$update && !is_object($entity)) {
                $this->getEntityManager()->persist($erpOrderItems);
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        } catch (\Doctrine\ORM\ORMException $e) {
            echo $e->getMessage();
        }
    }

    protected function getCustnoFromInvno($invno)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository('DemacMediaErpBundle:OroErpOrders')->findOneBy([
                'invno'  => $invno
            ]);

        if (!$em) {
            return false;
        } else {
            return $em->getCustno();
        }
    }

    protected function showDemacMediaHeader(OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('<demac>                                ');
        $output->writeln('                                ');
        $output->writeln('         DemacMedia.com         ');
        $output->writeln('                                ');
        $output->writeln('                                </demac>');
        $output->writeln('');
    }

    protected function checkIfCsvExist($csvfile, OutputInterface $output)
    {
        if (!is_readable($this->csvPath = self::CSV_FOLDER . $csvfile)) {
            $output->writeln('');
            $output->writeln('<error>        ERROR        </error>');
            $output->writeln(
                sprintf(
                    '<error>I can\'t read the .csv: %s</error>',
                    $this->csvPath
                )
            );
            $output->writeln('');
            die();
        }
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        }

        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);

        return $this->entityManager;
    }

    /**
     * @param Filename
     * @return String lines
     */
    protected function getLines($file)
    {
        $f = fopen($file, 'rb');
        $lines = 0;

        while (!feof($f)) {
            $lines += substr_count(fread($f, 8192), "\n");
        }

        fclose($f);
        return $lines;
    }
}
