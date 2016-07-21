<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_12;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Schema\Table;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\EntityExtendBundle\Extend\RelationType;
use Oro\Bundle\EntityExtendBundle\Migration\ExtendOptionsManager;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendHelper;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\TrackingBundle\Migration\Extension\VisitEventAssociationExtension;

class AddTrackingVisitAssociation implements
    Migration,
    ContainerAwareInterface,
    ExtendExtensionAwareInterface
{
    /** ContainerInterface */
    protected $container;

    /** @var ExtendExtension  */
    protected $extendExtension;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function setExtendExtension(ExtendExtension $extendExtension)
    {
        $this->extendExtension = $extendExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $visitTable   = $schema->getTable(VisitEventAssociationExtension::VISIT_EVENT_TABLE_NAME);
        $selfTableName  = $this->getTableName($visitTable);

        $targetTableName = 'demacmedia_erp_accounts';

        $options = [];
        $this->ensureExtendFieldSet($options);
        $options[ExtendOptionsManager::TARGET_OPTION] = [
            'table_name' => $targetTableName,
            'column'     => null,
        ];
        $options[ExtendOptionsManager::TYPE_OPTION]   = RelationType::MANY_TO_ONE;

        $associationName = ExtendHelper::buildAssociationName(
            $this->extendExtension->getEntityClassByTableName($targetTableName),
            VisitEventAssociationExtension::ASSOCIATION_KIND
        );

        $optionsManager = $this->container->get('oro_entity_extend.migration.options_manager');
        $optionsManager->setColumnOptions(
            $selfTableName,
            $associationName,
            $options
        );
    }

    /**
     * @param Table|string $table A Table object or table name
     *
     * @return string
     */
    protected function getTableName($table)
    {
        return $table instanceof Table ? $table->getName() : $table;
    }

    /**
     * Makes sure that required for any extend field attributes are set
     *
     * @param array $options
     */
    protected function ensureExtendFieldSet(array &$options)
    {
        if (!isset($options['extend'])) {
            $options['extend'] = [];
        }
        if (!isset($options['extend']['is_extend'])) {
            $options['extend']['is_extend'] = true;
        }
        if (!isset($options['extend']['owner'])) {
            $options['extend']['owner'] = ExtendScope::OWNER_SYSTEM;
        }
    }

    /**
     * @param Table|string $table A Table object or table name
     * @param Schema       $schema
     *
     * @return Table
     */
    protected function getTable($table, Schema $schema)
    {
        return $table instanceof Table ? $table : $schema->getTable($table);
    }

    /**
     * @param Table $table
     *
     * @return string
     *
     * @throws SchemaException if valid primary key does not exist
     */
    protected function getPrimaryKeyColumnName(Table $table)
    {
        if (!$table->hasPrimaryKey()) {
            throw new SchemaException(
                sprintf('The table "%s" must have a primary key.', $table->getName())
            );
        }
        $primaryKeyColumns = $table->getPrimaryKey()->getColumns();
        if (count($primaryKeyColumns) !== 1) {
            throw new SchemaException(
                sprintf('A primary key of "%s" table must include only one column.', $table->getName())
            );
        }

        return array_pop($primaryKeyColumns);
    }
}
