<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_16;

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

        $table->addColumn('number_of_orders_all', 'integer', ['notnull' => false]);
        $table->addIndex(['number_of_orders_all'], strtoupper('IDX_erp_num_of_orders_all'), []);
    }
}

