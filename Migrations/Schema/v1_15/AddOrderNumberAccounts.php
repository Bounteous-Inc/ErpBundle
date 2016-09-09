<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_15;

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
        $table = $schema->getTable('demacmedia_erp_carts');

        $table->addColumn('completed_order_id', 'integer', ['notnull' => false]);
        $table->addIndex(['completed_order_id'], strtoupper('IDX_erp_cmp_ord_id'), []);
    }
}
