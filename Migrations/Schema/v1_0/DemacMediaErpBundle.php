<?php

namespace DemacMedia\Bundle\DemacMediaErpBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class DemacMediaErpBundle implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        self::createDemacmediaErpAccountsTable($schema);
        self::createDemacmediaErpOrdersTable($schema);
        self::createDemacmediaErpOrderItemsTable($schema);

        /** Foreign keys generation **/
        self::addErpAccountsForeignKeys($schema);
        self::addErpOrdersForeignKeys($schema);
        self::addErpOrderItemsForeignKeys($schema);
    }

    /**
     * Creates ErpAccounts table
     *
     * @param Schema $schema
     */
    public static function createDemacmediaErpAccountsTable(Schema $schema)
    {
        $table = $schema->createTable('demacmedia_erp_accounts');

        $table->addColumn('id',         'integer',  ['autoincrement' => true]);
        $table->addColumn('custno',     'string',   ['length' => 32, 'notnull' => true]);
        $table->addColumn('company',    'string',   ['length' => 100, 'notnull' => false]);
        $table->addColumn('contact',    'string',   ['length' => 255, 'notnull' => true]);
        $table->addColumn('title',      'string',   ['length' => 32, 'notnull' => false]);
        $table->addColumn('address1',   'string',   ['length' => 255, 'notnull' => false]);
        $table->addColumn('address2',   'string',   ['length' => 255, 'notnull' => false]);
        $table->addColumn('city',       'string',   ['length' => 64, 'notnull' => true]);
        $table->addColumn('addrstate',  'string',   ['length' => 32, 'notnull' => false]);
        $table->addColumn('zip',        'string',   ['length' => 12, 'notnull' => false]);
        $table->addColumn('country',    'string',   ['length' => 64, 'notnull' => false]);
        $table->addColumn('phone',      'string',   ['length' => 32, 'notnull' => true]);
        $table->addColumn('phone2',     'string',   ['length' => 32, 'notnull' => false]);
        $table->addColumn('source',     'string',   ['length' => 32, 'notnull' => false]);
        $table->addColumn('type',       'string',   ['length' => 16, 'notnull' => false]);
        $table->addColumn('email',      'string',   ['length' => 255, 'notnull' => false]);
        $table->addColumn('custmemo',   'text',     ['notnull' => false]);
        $table->addColumn('url',        'string',   ['length' => 255, 'notnull' => false]);
        $table->addColumn('created',    'datetime', ['notnull' => false]);
        $table->addColumn('updated',    'datetime', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id',   'integer', ['notnull' => false]);
        $table->setPrimaryKey(['id']);

        $table->addIndex(['custno'],    strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['contact'],   strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['updated'],   strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['email'],     strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['city'],      strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['organization_id'], strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['user_owner_id'],   strtoupper(uniqid('IDX_')), []);

        $table->addUniqueIndex(array("custno"));
    }

    /**
     * Creates ErpOrders table
     *
     * @param Schema $schema
     */
    public static function createDemacmediaErpOrdersTable(Schema $schema)
    {
        $table = $schema->createTable('demacmedia_erp_orders');

        $table->addColumn('id',         'integer',  ['autoincrement' => true]);

        $table->addColumn('custno',     'string',   ['length' => 32, 'notnull' => true]);
        $table->addColumn('invno',      'string',   ['length' => 32, 'notnull' => true]);
        $table->addColumn('invdate',    'datetime', ['notnull' => false]);
        $table->addColumn('shipvia',    'string',   ['length' => 32, 'notnull' => false]);
        $table->addColumn('cshipno',    'string',   ['length' => 32, 'notnull' => false]);
        $table->addColumn('taxrate',    'float',    ['notnull' => false]);
        $table->addColumn('tax',        'float',    ['notnull' => false]);
        $table->addColumn('invamt',     'float',    ['notnull' => false]);
        $table->addColumn('ponum',      'string',   ['length' => 32, 'notnull' => false]);
        $table->addColumn('refno',      'string',   ['length' => 32, 'notnull' => false]);
        $table->addColumn('created',    'datetime', ['notnull' => false]);
        $table->addColumn('updated',    'datetime', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id',   'integer', ['notnull' => false]);
        $table->setPrimaryKey(['id']);

        $table->addIndex(['invno'],  strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['custno'],  strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['invdate'], strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['organization_id'], strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['user_owner_id'],   strtoupper(uniqid('IDX_')), []);
    }

    /**
     * Creates ErpOrderItems table
     *
     * @param Schema $schema
     */
    public static function createDemacmediaErpOrderItemsTable(Schema $schema)
    {
        $table = $schema->createTable('demacmedia_erp_order_items');

        $table->addColumn('id',        'integer',   ['autoincrement' => true]);
        $table->addColumn('invno',      'string',   ['length' => 32, 'notnull' => true]);
        $table->addColumn('custno',     'string',   ['length' => 32, 'notnull' => true]);
        $table->addColumn('item',      'string',    ['length' => 255, 'notnull' => false]);
        $table->addColumn('descrip',   'string',    ['length' => 255, 'notnull' => false]);
        $table->addColumn('taxrate',   'float',     ['notnull' => false]);
        $table->addColumn('cost',      'float',     ['notnull' => false]);
        $table->addColumn('price',     'float',     ['notnull' => false]);
        $table->addColumn('qtyord',    'float',     ['notnull' => false]);
        $table->addColumn('qtyshp',    'float',     ['notnull' => false]);
        $table->addColumn('extprice',  'float',     ['notnull' => false]);
        $table->addColumn('invdate',   'datetime',  ['notnull' => false]);
        $table->addColumn('created',   'datetime',  ['notnull' => false]);
        $table->addColumn('updated',   'datetime',  ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id',   'integer', ['notnull' => false]);
        $table->setPrimaryKey(['id']);

        $table->addIndex(['invno'],  strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['custno'],  strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['invdate'], strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['organization_id'], strtoupper(uniqid('IDX_')), []);
        $table->addIndex(['user_owner_id'],   strtoupper(uniqid('IDX_')), []);
    }


    /**
     * Add ErpAccounts foreign keys.
     *
     * @param Schema $schema
     */
    public static function addErpAccountsForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('demacmedia_erp_accounts');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
    }

    /**
     * Add ErpOrders foreign keys.
     *
     * @param Schema $schema
     */
    public static function addErpOrdersForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('demacmedia_erp_orders');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
    }

    /**
     * Add ErpOrderItems foreign keys.
     *
     * @param Schema $schema
     */
    public static function addErpOrderItemsForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('demacmedia_erp_order_items');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
    }

}
