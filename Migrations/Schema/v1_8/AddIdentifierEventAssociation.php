<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_8;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\TrackingBundle\Migration\Extension\IdentifierEventExtension;
use Oro\Bundle\TrackingBundle\Migration\Extension\IdentifierEventExtensionAwareInterface;

class AddIdentifierEventAssociation implements Migration, IdentifierEventExtensionAwareInterface
{
    /** @var IdentifierEventExtension */
    protected $extension;
    /**
     * {@inheritdoc}
     */
    public function setIdentifierEventExtension(IdentifierEventExtension $extension)
    {
        $this->extension = $extension;
    }
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $this->extension->addIdentifierAssociation($schema, 'demacmedia_erp_accounts');
    }
}
