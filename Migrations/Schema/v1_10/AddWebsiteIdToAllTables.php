<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_10;

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
        $this->addWebsiteIdToOrders($schema);
        $this->addWebsiteIdToOrderItems($schema);
    }

    /**
     * Creates WebsiteId in WebOrders table
     *
     * @param Schema $schema
     */
    public function addWebsiteIdToOrders(Schema $schema)
    {
        $table = $schema->getTable('demacmedia_erp_orders');
        $table->addColumn('website_id', 'string', ['notnull' => false]);
        $table->addIndex(['website_id'], strtoupper('IDX_orders_website_id'), []);
    }

    /**
     * Creates WebsiteId in WebOrderItems table
     *
     * @param Schema $schema
     */
    public function addWebsiteIdToOrderItems(Schema $schema)
    {
        $table = $schema->getTable('demacmedia_erp_order_items');
        $table->addColumn('website_id', 'string', ['notnull' => false]);
        $table->addIndex(['website_id'], strtoupper('IDX_ordersit_website_id'), []);
    }
}
