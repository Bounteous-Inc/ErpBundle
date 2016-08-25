<?php

namespace DemacMedia\Bundle\ErpBundle\EventListener\Datagrid;

use Doctrine\ORM\Query\Expr;
use Oro\Bundle\DataGridBundle\Datagrid\Common\DatagridConfiguration;
use Oro\Bundle\DataGridBundle\Event\BuildBefore;

class ChangeAccountDatagridListener
{
    /**
     * @param BuildBefore $event
     */
    public function onBuildBefore(BuildBefore $event)
    {
        $configuration = $event->getDatagrid()->getConfig();
        $this->addColumns($configuration);
        $this->delColumns($configuration);
        return $event;
    }

    /**
     * @param DatagridConfiguration $configuration
     */
    public function addColumns(DatagridConfiguration $configuration)
    {
        $customSelect = [
            'erp_accounts.lifetime',
            'erp_accounts.lifetimeall',
            'erp_accounts.numberOfOrders'
        ];

        $joinPath = '[source][query][join][left]';
        $customJoin = [
            'join' => 'DemacMediaErpBundle:OroErpAccounts',
            'alias' => 'erp_accounts',
            'conditionType' => 'WITH',
            'condition' => 'a.id = IDENTITY(erp_accounts.account)'
        ];

        $customColumns = [
            'lifetime' => [
                'label' => 'Lifetime',
                'frontend_type' => 'currency'
            ],
            'lifetimeall' => [
                'label' => 'LifetimeAll',
                'frontend_type' => 'currency'
            ],
            'numberOfOrders' => [
                'label' => 'Number of Orders',
                'frontend_type' => 'number'
            ]
        ];

        $customFilters = [
            'lifetime' => [
                'type' => 'currency',
                'data_name' => 'erp_accounts.lifetime'
            ],
            'lifetimeall' => [
                'type' => 'currency',
                'data_name' => 'erp_accounts.lifetimeall'
            ],
            'numberOfOrders' => [
                'type' => 'number',
                'data_name' => 'erp_accounts.numberOfOrders'
            ]
        ];

        $customSorters = [
            'lifetime' => [
                'data_name' => 'erp_accounts.lifetime'
            ],
            'lifetimeall' => [
                'data_name' => 'erp_accounts.lifetimeall'
            ],
            'numberOfOrders' => [
                'data_name' => 'erp_accounts.numberOfOrders'
            ]
        ];

        $configuration->offsetAddToArrayByPath(
            '[source][query][select]', $customSelect
        );

        $configuration->offsetAddToArrayByPath(
            sprintf('%s[%d]',
                $joinPath,
                sizeof($configuration->offsetGetByPath(
                    $joinPath
                ))),
            $customJoin
        );

        $configuration->offsetAddToArrayByPath(
            '[columns]', $customColumns
        );

        $configuration->offsetAddToArrayByPath(
            '[filters][columns]', $customFilters
        );

        $configuration->offsetAddToArrayByPath(
            '[sorters][columns]', $customSorters
        );

        $configuration->offsetSetByPath(
            '[sorters][default]', [
                'updatedAt' => 'DESC'
            ]
        );
    }

    /**
     * @param DatagridConfiguration $configuration
     */
    public function delColumns(DatagridConfiguration $configuration)
    {
        $configuration->offsetUnsetByPath(
            '[columns][contactPhone]'
        );

        $configuration->offsetUnsetByPath(
            '[sorters][columns][contactPhone]'
        );

        $configuration->offsetUnsetByPath(
            '[filters][columns][contactPhone]'
        );
    }
}
