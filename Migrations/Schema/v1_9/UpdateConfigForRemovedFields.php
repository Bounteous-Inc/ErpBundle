<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_9;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\ParametrizedSqlMigrationQuery;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class UpdateConfigForRemovedFields implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $classList = [
            'DemacMedia\\Bundle\\ErpBundle\\Entity\\OroErpAccounts',
            'DemacMedia\\Bundle\\ErpBundle\\Entity\\OroErpOrders',
            'DemacMedia\\Bundle\\ErpBundle\\Entity\\OroErpOrderItems'
        ];

        foreach($classList as $classConfig){
            $configDropQuery = new ParametrizedSqlMigrationQuery();

            $configDropQuery->addSql(
                $this->getRemoveObsoleteFieldsSql(),
                ['class_name' => $classConfig]
            );

            $queries->addPostQuery($configDropQuery);
        }
    }

    /**
     * @return string
     */
    protected function getRemoveObsoleteFieldsSql()
    {
        return "DELETE ofi.* FROM oro_entity_config_field ofi
            INNER JOIN oro_entity_config o
	        ON ofi.entity_id = o.id
            WHERE
	        o.class_name = :class_name";
    }
}
