<?php

namespace DemacMedia\Bundle\ErpBundle\Provider;

use Oro\Bundle\IntegrationBundle\Provider\ChannelInterface;
use Oro\Bundle\IntegrationBundle\Provider\IconAwareIntegrationInterface;

class ErpChannelType implements ChannelInterface
{
    const TYPE = 'erp';

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'demacmedia_erp.erp.channel_type.label';
    }

}
