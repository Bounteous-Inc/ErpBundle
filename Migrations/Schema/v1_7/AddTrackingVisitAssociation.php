<?php

namespace DemacMedia\Bundle\ErpBundle\Migrations\Schema\v1_7;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\TrackingBundle\Migration\Extension\VisitEventAssociationExtension;
use Oro\Bundle\TrackingBundle\Migration\Extension\VisitEventAssociationExtensionAwareInterface;

class AddTrackingVisitAssociation implements Migration, VisitEventAssociationExtensionAwareInterface
{
    /** @var VisitEventAssociationExtension */
    protected $extension;
    /**
     * {@inheritdoc}
     */
    public function setVisitEventAssociationExtension(VisitEventAssociationExtension $extension)
    {
        $this->extension = $extension;
    }
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $this->extension->addVisitEventAssociation($schema, 'demacmedia_erp_accounts');
    }
}
