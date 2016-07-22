<?php

namespace DemacMedia\Bundle\ErpBundle\Provider;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\EntityConfigBundle\Provider\ConfigProvider;
use Oro\Bundle\TrackingBundle\Entity\TrackingVisit;
use Oro\Bundle\TrackingBundle\Entity\TrackingVisitEvent;
use Oro\Bundle\TrackingBundle\Provider\TrackingEventIdentifierInterface;

use OroCRM\Bundle\ChannelBundle\Entity\Channel;
use OroCRM\Bundle\ChannelBundle\Provider\SettingsProvider;


class CustomerIdentification implements TrackingEventIdentifierInterface
{
    const EVENT_REGISTRATION_FINISHED = 'user registration';
    const EVENT_CART_ITEM_ADDED       = 'cart item added to cart';
    const EVENT_CHECKOUT_STARTED      = 'user entered checkout';
    const EVENT_ORDER_PLACE_SUCCESS   = 'order successfully placed';
    const EVENT_PRODUCT_VIEW          = 'product viewed'; // product%20viewed
    const EVENT_VISIT                 = 'visit';
    const EVENT_USER_LOGGED_IN        = 'User logged In';

    /** @var ObjectManager */
    protected $em;
    /** @var  ConfigProvider */
    protected $extendConfigProvider;
    /** @var  SettingsProvider */
    protected $settingsProvider;
    /** @var TrackingEventIdentifierInterface[] */
    protected $providers = [];

    /**
     * @param Registry         $doctrine
     * @param ConfigProvider   $extendConfigProvider
     * @param SettingsProvider $settingsProvider
     */
    public function __construct(
        Registry $doctrine,
        ConfigProvider $extendConfigProvider,
        SettingsProvider $settingsProvider
    ) {
        $this->em                   = $doctrine->getManager();
        $this->extendConfigProvider = $extendConfigProvider;
        $this->settingsProvider     = $settingsProvider;
    }

    /**
     * Add activity list provider
     *
     * @param TrackingEventIdentifierInterface $provider
     */
    public function addProvider(TrackingEventIdentifierInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function isApplicable(TrackingVisit $trackingVisit)
    {
        /**
         * Here we checks if given tracking visit can be identified by our provider.
         */

        $hasTrackingWebsiteChannel = $this->extendConfigProvider->hasConfig(
            'Oro\Bundle\TrackingBundle\Entity\TrackingWebsite',
            'channel'
        );
        if ($hasTrackingWebsiteChannel) {
            $trackingWebsite = $trackingVisit->getTrackingWebsite();
            if (method_exists($trackingWebsite, 'getChannel')) {
                /** @var Channel $channel */
                $channel = $trackingWebsite->getChannel();
                $type    = $channel ? $channel->getChannelType() : false;
                if ($type && $type === 'custom') {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * The main logic, in most cases it will be the same.
     *
     * {@inheritdoc}
     */
    public function identify(TrackingVisit $trackingVisit)
    {
        $userIdentifier = $trackingVisit->getParsedUID() > 0
            ? $trackingVisit->getParsedUID()
            : $this->parse($trackingVisit->getUserIdentifier());

        if ($userIdentifier) {
            $result = [
                'parsedUID'    => $userIdentifier,
                'targetObject' => null
            ];

            $websiteIdentifier = $trackingVisit->getTrackingWebsite()->getIdentifier();
            $target  = $this->em->getRepository($this->getIdentityTarget())->findOneBy(
                [
                    'accountNumber' => $userIdentifier,
                    'websiteId' => $websiteIdentifier
                ]
            );

            if ($target) {
                $result['targetObject'] = $target;
            }

            return $result;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentityTarget()
    {
        /**
         * Here we should return object's class name for which given tracking visit will be assigned to.
         */
        return 'DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts';
    }

    /**
     * {@inheritdoc}
     */
    public function isApplicableVisitEvent(TrackingVisitEvent $trackingVisitEvent)
    {
        /**
         * should return true if this processor can process given visit event
         */

        $hasTrackingWebsiteChannel = $this->extendConfigProvider->hasConfig(
            'Oro\Bundle\TrackingBundle\Entity\TrackingWebsite',
            'channel'
        );
        if ($hasTrackingWebsiteChannel) {
            $trackingWebsite = $trackingVisitEvent->getVisit()->getTrackingWebsite();
            if (method_exists($trackingWebsite, 'getChannel')) {
                /** @var Channel $channel */
                $channel = $trackingWebsite->getChannel();
                $type    = $channel ? $channel->getChannelType() : false;
                if ($type && $type === 'custom') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function processEvent(TrackingVisitEvent $trackingVisitEvent)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getEventTargets()
    {
        return [
            'DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts'
        ];
    }

    /**
     * Parse user identifier string and returns value by which identity object can be retrieved.
     * Returns null in case identifier is not found.
     *
     * @param string $identifier
     *
     * @return string|null
     */
    protected function parse($identifier = null)
    {
        if (!empty($identifier)) {
            $identifierArray = explode('; ', $identifier);
            $identifierData  = [];
            array_walk(
                $identifierArray,
                function ($string) use (&$identifierData) {
                    $data = explode('=', $string);
                    if (count($data) === 2) {
                        $identifierData[$data[0]] = $data[1];
                    }
                }
            );
            if (array_key_exists('id', $identifierData) && $identifierData['id'] !== 'guest') {
                return $identifierData['id'];
            }
        }
        return null;
    }
}
