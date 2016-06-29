<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_6;

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

        $table->addColumn('lifetime', 'money', ['notnull' => false]);
        $table->addIndex(['lifetime'], strtoupper('IDX_erp_lifetime'), []);
    }
}
