<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_2;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Extension\RenameExtension;
use Oro\Bundle\MigrationBundle\Migration\Extension\RenameExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class DemacMediaErpBundle implements Migration, RenameExtensionAwareInterface
{
    /**
     * @var RenameExtension
     */
    public $renameExtension;


    /**
     * {@inheritdoc}
     */
    public function setRenameExtension(RenameExtension $renameExtension)
    {
        $this->renameExtension = $renameExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $this->renameContactColumn($schema, $queries);
        $this->addAccountAndContactColumns($schema, $queries);

        $queries->addQuery(
            "INSERT IGNORE INTO orocrm_contact_source (name, label) VALUES ('webstore', 'Web-Store')"
        );
    }

    /**
     * Creates ErpAccounts table
     *
     * @param Schema $schema
     */
    public function renameContactColumn(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable('demacmedia_erp_accounts');
        $this->renameExtension->renameColumn(
            $schema,
            $queries,
            $table,
            'contact',
            'contactname'
        );
    }

    public function addAccountAndContactColumns(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable('demacmedia_erp_accounts');

        $table->addColumn('account_id', 'integer', ['notnull' => false]);
        $table->addColumn('contact_id', 'integer', ['notnull' => false]);

        $table->addIndex(['account_id'], strtoupper('IDX_erp_account_id'), []);
        $table->addIndex(['contact_id'], strtoupper('IDX_erp_contact_id'), []);
    }
}
