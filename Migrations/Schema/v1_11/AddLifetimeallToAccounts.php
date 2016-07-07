<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_11;

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

        $table->addColumn('lifetimeall', 'money', ['notnull' => false]);
        $table->addIndex(['lifetimeall'], strtoupper('IDX_erp_lifetimeall'), []);
    }
}
