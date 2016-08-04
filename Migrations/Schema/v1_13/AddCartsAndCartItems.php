<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_13;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddCartsAndCartItems implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->createTable('demacmedia_erp_carts');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('cart_number', 'integer', ['notnull' => true]);
        $table->addColumn('erpaccount_id', 'integer', ['notnull' => true]);
        $table->addColumn('original_email', 'string', ['notnull' => true]);
        $table->addColumn('total_paid', 'float', ['notnull' => true]);
        $table->addColumn('created_at', 'datetime', ['notnull' => false]);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->addColumn('created', 'datetime', ['notnull' => false]);
        $table->addColumn('updated', 'datetime', ['notnull' => false]);
        $table->addColumn('cart_status', 'string', ['notnull' => true]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
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
        $table->addColumn('website_id', 'string', ['notnull' => false]);
        
        $table->addIndex(['cart_number'], strtoupper('IDX_orig_cart_number'), []);
        $table->addIndex(['erpaccount_id'], strtoupper('IDX_cart_erpaccount_id'), []);
        $table->addIndex(['original_email'], strtoupper('IDX_crt_orig_email'), []);
        $table->addIndex(['total_paid'], strtoupper('IDX_cart_total_paid'), []);
        $table->addIndex(['created_at'], strtoupper('IDX_cart_created_at'), []);
        $table->addIndex(['updated_at'], strtoupper('IDX_cart_updated_at'), []);
        $table->addIndex(['created'], strtoupper('IDX_cart_created'), []);
        $table->addIndex(['updated'], strtoupper('IDX_cart_updated'), []);
        $table->addIndex(['organization_id'], strtoupper('IDX_cart_organization_id'), []);
        $table->addIndex(['user_owner_id'], strtoupper('IDX_cart_user_owner_id'), []);
        $table->addIndex(['bill_firstname'], strtoupper('IDX_carts_bill_firstname'), []);
        $table->addIndex(['bill_lastname'], strtoupper('IDX_carts_bill_lastname'), []);
        $table->addIndex(['bill_company'], strtoupper('IDX_carts_bill_company'), []);
        $table->addIndex(['bill_address1'], strtoupper('IDX_carts_bill_address1'), []);
        $table->addIndex(['bill_address2'], strtoupper('IDX_carts_bill_address2'), []);
        $table->addIndex(['bill_city'], strtoupper('IDX_carts_bill_city'), []);
        $table->addIndex(['bill_state'], strtoupper('IDX_carts_bill_state'), []);
        $table->addIndex(['bill_zip'], strtoupper('IDX_carts_bill_zip'), []);
        $table->addIndex(['bill_phone'], strtoupper('IDX_carts_bill_phone'), []);
        $table->addIndex(['ship_firstname'], strtoupper('IDX_carts_ship_firstname'), []);
        $table->addIndex(['ship_lastname'], strtoupper('IDX_carts_ship_lastname'), []);
        $table->addIndex(['ship_company'], strtoupper('IDX_carts_ship_company'), []);
        $table->addIndex(['ship_address1'], strtoupper('IDX_carts_ship_address1'), []);
        $table->addIndex(['ship_address2'], strtoupper('IDX_carts_ship_address2'), []);
        $table->addIndex(['ship_city'], strtoupper('IDX_carts_ship_city'), []);
        $table->addIndex(['ship_state'], strtoupper('IDX_carts_ship_state'), []);
        $table->addIndex(['ship_zip'], strtoupper('IDX_carts_ship_zip'), []);
        $table->addIndex(['ship_phone'], strtoupper('IDX_carts_ship_phone'), []);
        $table->addIndex(['website_id'], strtoupper('IDX_carts_website_id'), []);
        $table->setPrimaryKey(['id']);



        $table = $schema->createTable('demacmedia_erp_cart_items');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('cart_item_number', 'integer', ['notnull' => true]);
        $table->addColumn('cart_id', 'integer', ['notnull' => false]);
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
        $table->addColumn('website_id', 'string', ['notnull' => false]);

        $table->addIndex(['cart_item_number'], strtoupper('IDX_orig_crt_item_numb'), []);
        $table->addIndex(['cart_id'], strtoupper('IDX_cart_id'), []);
        $table->addIndex(['sku'], strtoupper('IDX_cart_sku'), []);
        $table->addIndex(['product_name'], strtoupper('IDX_cart_product_name'), []);
        $table->addIndex(['product_price'], strtoupper('IDX_cart_product_price'), []);
        $table->addIndex(['quantity'], strtoupper('IDX_cart_quantity'), []);
        $table->addIndex(['created_at'], strtoupper('IDX_cart_created_at'), []);
        $table->addIndex(['updated_at'], strtoupper('IDX_cart_updated_at'), []);
        $table->addIndex(['created'], strtoupper('IDX_cart_created'), []);
        $table->addIndex(['updated'], strtoupper('IDX_cart_updated'), []);
        $table->addIndex(['organization_id'], strtoupper('IDX_cart_organization_id'), []);
        $table->addIndex(['user_owner_id'], strtoupper('IDX_cart_user_owner_id'), []);
        $table->addIndex(['website_id'], strtoupper('IDX_cartsit_website_id'), []);
        $table->setPrimaryKey(['id']);

        $this->addOrdersForeignKeys($schema);
        $this->addOrderItemsForeignKeys($schema);
    }

    /**
     * Add demacmedia_erp_carts foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOrdersForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('demacmedia_erp_carts');
        $table->addForeignKeyConstraint(
            $schema->getTable('demacmedia_erp_accounts'),
            ['erpaccount_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
    }


    /**
     * Add demacmedia_erp_cart_items foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOrderItemsForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('demacmedia_erp_cart_items');
        $table->addForeignKeyConstraint(
            $schema->getTable('demacmedia_erp_carts'),
            ['cart_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
    }

}
