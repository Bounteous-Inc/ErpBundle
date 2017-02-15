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
        $this->delColumns($configuration);
        $this->addColumns($configuration);
        return $event;
    }

    /**
     * @param DatagridConfiguration $configuration
     */
    public function addColumns(DatagridConfiguration $configuration)
    {
        $customSelect = [
            'erp_accounts.originalEmail',
            'erp_accounts.websiteId',
            'erp_accounts.lifetime',
            'erp_accounts.lifetimeall',
            'erp_accounts.numberOfOrders'
        ];

        $joinPath = '[source][query][join][inner]';
        $customJoin = [
            'join' => 'DemacMediaErpBundle:OroErpAccounts',
            'alias' => 'erp_accounts',
            'conditionType' => 'WITH',
            'condition' => 'a.id = IDENTITY(erp_accounts.account)'
        ];

        $customColumns = [
            'originalEmail' => [
                'label' => 'Email',
                'frontend_type' => 'string'
            ],
            'websiteId' => [
                'label' => 'WebsiteID',
                'frontend_type' => 'string'
            ],
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
            'originalEmail' => [
                'type' => 'string',
                'data_name' => 'erp_accounts.originalEmail'
            ],
            'websiteId' => [
                'type' => 'string',
                'data_name' => 'erp_accounts.websiteId'
            ],
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
            'originalEmail' => [
                'data_name' => 'erp_accounts.originalEmail'
            ],
            'websiteId' => [
                'data_name' => 'erp_accounts.websiteId'
            ],
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

        $createdAt = $configuration->offsetGetByPath('[columns][createdAt]');
        $updatedAt = $configuration->offsetGetByPath('[columns][updatedAt]');

        $configuration->offsetUnsetByPath('[columns][createdAt]');
        $configuration->offsetUnsetByPath('[columns][updatedAt]');

        $configuration->offsetAddToArrayByPath(
            '[columns]', $customColumns
        );
        $configuration->offsetAddToArrayByPath('[columns][createdAt]', $createdAt);
        $configuration->offsetAddToArrayByPath('[columns][updatedAt]', $updatedAt);

        $configuration->offsetAddToArrayByPath(
            '[filters][columns]', $customFilters
        );

        $configuration->offsetAddToArrayByPath(
            '[sorters][columns]', $customSorters
        );

        $configuration->offsetSetByPath(
            '[sorters][default]', [
                'id' => 'DESC'
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
            '[columns][contactName]'
        );
        $configuration->offsetUnsetByPath(
            '[columns][ownerName]'
        );
        $configuration->offsetUnsetByPath(
            '[columns][contactEmail]'
        );


        $configuration->offsetUnsetByPath(
            '[sorters][columns][contactPhone]'
        );
        $configuration->offsetUnsetByPath(
            '[sorters][columns][contactName]'
        );
        $configuration->offsetUnsetByPath(
            '[sorters][columns][ownerName]'
        );
        $configuration->offsetUnsetByPath(
            '[sorters][columns][contactEmail]'
        );


        $configuration->offsetUnsetByPath(
            '[filters][columns][contactName]'
        );
        $configuration->offsetUnsetByPath(
            '[filters][columns][contactPhone]'
        );
        $configuration->offsetUnsetByPath(
            '[filters][columns][ownerName]'
        );
        $configuration->offsetUnsetByPath(
            '[filters][columns][contactEmail]'
        );
    }
}
