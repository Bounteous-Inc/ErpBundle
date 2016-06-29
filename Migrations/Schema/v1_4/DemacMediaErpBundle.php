<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_4;

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
        $table = $schema->createTable('demacmedia_erp_accounts');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('account_number', 'integer', ['notnull' => true]);
        $table->addColumn('first_name', 'string', ['notnull' => true]);
        $table->addColumn('last_name', 'string', ['notnull' => true]);
        $table->addColumn('email', 'string', ['notnull' => true]);
        $table->addColumn('original_email', 'string', ['notnull' => true]);
        $table->addColumn('website_id', 'string', ['notnull' => true]);
        $table->addColumn('created_at', 'datetime', ['notnull' => false]);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->addColumn('created', 'datetime', ['notnull' => false]);
        $table->addColumn('updated', 'datetime', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('account_id', 'integer', ['notnull' => false]);
        $table->addColumn('contact_id', 'integer', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['account_number'], strtoupper('IDX_act_number'), []);
        $table->addIndex(['first_name'], strtoupper('IDX_first_name'), []);
        $table->addIndex(['last_name'], strtoupper('IDX_last_name'), []);
        $table->addIndex(['email'], strtoupper('IDX_email'), []);
        $table->addIndex(['original_email'], strtoupper('IDX_original_email'), []);
        $table->addIndex(['website_id'], strtoupper('IDX_website_id'), []);
        $table->addIndex(['created_at'], strtoupper('IDX_created_at'), []);
        $table->addIndex(['updated_at'], strtoupper('IDX_updated_at'), []);
        $table->addIndex(['created'], strtoupper('IDX_created'), []);
        $table->addIndex(['updated'], strtoupper('IDX_updated'), []);
        $table->addIndex(['organization_id'], strtoupper('IDX_organization_id'), []);
        $table->addIndex(['user_owner_id'], strtoupper('IDX_user_owner_id'), []);
        $table->addUniqueIndex(array("original_email"));



        $table = $schema->createTable('demacmedia_erp_orders');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('order_number', 'integer', ['notnull' => true]);
        $table->addColumn('erpaccount_id', 'integer', ['notnull' => true]);
        $table->addColumn('original_email', 'string', ['notnull' => true]);
        $table->addColumn('total_paid', 'float', ['notnull' => true]);
        $table->addColumn('created_at', 'datetime', ['notnull' => false]);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->addColumn('created', 'datetime', ['notnull' => false]);
        $table->addColumn('updated', 'datetime', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addIndex(['order_number'], strtoupper('IDX_orig_order_number'), []);
        $table->addIndex(['erpaccount_id'], strtoupper('IDX_erpaccount_id'), []);
        $table->addIndex(['original_email'], strtoupper('IDX_ord_orig_email'), []);
        $table->addIndex(['total_paid'], strtoupper('IDX_total_paid'), []);
        $table->addIndex(['created_at'], strtoupper('IDX_created_at'), []);
        $table->addIndex(['updated_at'], strtoupper('IDX_updated_at'), []);
        $table->addIndex(['created'], strtoupper('IDX_created'), []);
        $table->addIndex(['updated'], strtoupper('IDX_updated'), []);
        $table->addIndex(['organization_id'], strtoupper('IDX_organization_id'), []);
        $table->addIndex(['user_owner_id'], strtoupper('IDX_user_owner_id'), []);
        $table->setPrimaryKey(['id']);



        $table = $schema->createTable('demacmedia_erp_order_items');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('order_item_number', 'integer', ['notnull' => true]);
        $table->addColumn('order_id', 'integer', ['notnull' => false]);
        $table->addColumn('sku', 'string', ['notnull' => true]);
        $table->addColumn('product_name', 'string', ['notnull' => false]);
        $table->addColumn('product_price', 'string', ['notnull' => true]);
        $table->addColumn('quantity', 'integer', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['notnull' => false]);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->addColumn('created', 'datetime', ['notnull' => false]);
        $table->addColumn('updated', 'datetime', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addIndex(['order_item_number'], strtoupper('IDX_orig_ord_item_numb'), []);
        $table->addIndex(['order_id'], strtoupper('IDX_order_id'), []);
        $table->addIndex(['sku'], strtoupper('IDX_sku'), []);
        $table->addIndex(['product_name'], strtoupper('IDX_product_name'), []);
        $table->addIndex(['product_price'], strtoupper('IDX_product_price'), []);
        $table->addIndex(['quantity'], strtoupper('IDX_quantity'), []);
        $table->addIndex(['created_at'], strtoupper('IDX_created_at'), []);
        $table->addIndex(['updated_at'], strtoupper('IDX_updated_at'), []);
        $table->addIndex(['created'], strtoupper('IDX_created'), []);
        $table->addIndex(['updated'], strtoupper('IDX_updated'), []);
        $table->addIndex(['organization_id'], strtoupper('IDX_organization_id'), []);
        $table->addIndex(['user_owner_id'], strtoupper('IDX_user_owner_id'), []);
        $table->setPrimaryKey(['id']);

        $this->addOrdersForeignKeys($schema);
        $this->addOrderItemsForeignKeys($schema);
    }

    /**
     * Add demacmedia_erp_orders foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOrdersForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('demacmedia_erp_orders');
        $table->addForeignKeyConstraint(
            $schema->getTable('demacmedia_erp_accounts'),
            ['erpaccount_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
    }


    /**
     * Add demacmedia_erp_order_items foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOrderItemsForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('demacmedia_erp_order_items');
        $table->addForeignKeyConstraint(
            $schema->getTable('demacmedia_erp_orders'),
            ['order_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
    }

}
