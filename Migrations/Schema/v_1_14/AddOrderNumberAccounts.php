<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_14;

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
        $table = $schema->getTable('demacmedia_erp_accounts');

        $table->addColumn('number_of_orders', 'integer', ['notnull' => false]);
        $table->addIndex(['number_of_orders'], strtoupper('IDX_erp_num_of_orders'), []);
    }
}
