<?php

namespace DemacMedia\Bundle\DemacMediaErpBundle\Migrations\Schema\v1_3;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class DemacMediaErpBundle implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $schema->dropTable('demacmedia_erp_accounts');
        $schema->dropTable('demacmedia_erp_orders');
        $schema->dropTable('demacmedia_erp_order_items');
    }
}
