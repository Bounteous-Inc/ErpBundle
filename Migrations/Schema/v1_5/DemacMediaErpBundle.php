<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_5;

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
        $table = $schema->getTable('demacmedia_erp_orders');

        $table->addColumn('bill_firstname', 'string', ['length' => 32, 'notnull' => false]);
        $table->addColumn('bill_lastname', 'string', ['length' => 32, 'notnull' => false]);
        $table->addColumn('bill_company', 'string', ['notnull' => false]);
        $table->addColumn('bill_address1', 'string', ['notnull' => false]);
        $table->addColumn('bill_address2', 'string', ['notnull' => false]);
        $table->addColumn('bill_city', 'string', ['length' => 64, 'notnull' => false]);
        $table->addColumn('bill_state', 'string', ['length' => 64, 'notnull' => false]);
        $table->addColumn('bill_zip', 'string', ['length' => 32, 'notnull' => false]);
        $table->addColumn('bill_phone', 'string', ['length' => 32, 'notnull' => false]);
        $table->addColumn('ship_firstname', 'string', ['length' => 32, 'notnull' => false]);
        $table->addColumn('ship_lastname', 'string', ['length' => 32, 'notnull' => false]);
        $table->addColumn('ship_company', 'string', ['notnull' => false]);
        $table->addColumn('ship_address1', 'string', ['notnull' => false]);
        $table->addColumn('ship_address2', 'string', ['notnull' => false]);
        $table->addColumn('ship_city', 'string', ['length' => 64, 'notnull' => false]);
        $table->addColumn('ship_state', 'string', ['length' => 64, 'notnull' => false]);
        $table->addColumn('ship_zip', 'string', ['length' => 32, 'notnull' => false]);
        $table->addColumn('ship_phone', 'string', ['length' => 32, 'notnull' => false]);

        $table->addIndex(['bill_firstname'], strtoupper('IDX_orders_bill_firstname'), []);
        $table->addIndex(['bill_lastname'], strtoupper('IDX_orders_bill_lastname'), []);
        $table->addIndex(['bill_company'], strtoupper('IDX_orders_bill_company'), []);
        $table->addIndex(['bill_address1'], strtoupper('IDX_orders_bill_address1'), []);
        $table->addIndex(['bill_address2'], strtoupper('IDX_orders_bill_address2'), []);
        $table->addIndex(['bill_city'], strtoupper('IDX_orders_bill_city'), []);
        $table->addIndex(['bill_state'], strtoupper('IDX_orders_bill_state'), []);
        $table->addIndex(['bill_zip'], strtoupper('IDX_orders_bill_zip'), []);
        $table->addIndex(['bill_phone'], strtoupper('IDX_orders_bill_phone'), []);
        $table->addIndex(['ship_firstname'], strtoupper('IDX_orders_ship_firstname'), []);
        $table->addIndex(['ship_lastname'], strtoupper('IDX_orders_ship_lastname'), []);
        $table->addIndex(['ship_company'], strtoupper('IDX_orders_ship_company'), []);
        $table->addIndex(['ship_address1'], strtoupper('IDX_orders_ship_address1'), []);
        $table->addIndex(['ship_address2'], strtoupper('IDX_orders_ship_address2'), []);
        $table->addIndex(['ship_city'], strtoupper('IDX_orders_ship_city'), []);
        $table->addIndex(['ship_state'], strtoupper('IDX_orders_ship_state'), []);
        $table->addIndex(['ship_zip'], strtoupper('IDX_orders_ship_zip'), []);
        $table->addIndex(['ship_phone'], strtoupper('IDX_orders_ship_phone'), []);
    }
}
