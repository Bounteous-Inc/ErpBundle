<?php

namespace DemacMedia\Bundle\ErpBundle\Twig;

use OroCRM\Bundle\AccountBundle\Entity\Account;
use OroCRM\Bundle\ChannelBundle\Entity\Channel;

class NumberOfOrdersValueExtension extends \Twig_Extension
{
    const EXTENSION_NAME = 'demacmedia_erp_number_of_orders_value';

    protected $lifetimeHelper;

    public function __construct($lifetimeHelper)
    {
        $this->lifetimeHelper = $lifetimeHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $numberOfOrdersValue = new \Twig_SimpleFunction(
            'number_of_orders_all', [
                $this, 
                'getNumberOfOrdersValue'
            ]
        );

        return [$numberOfOrdersValue->getName() => $numberOfOrdersValue];
    }

    /**
     * @param Account $account
     * @param Channel $channel
     *
     * @return float
     */
    public function getNumberOfOrdersValue(Account $account, Channel $channel = null)
    {
        $defaultContact = $account->getDefaultContact();
        if (!$defaultContact) {
            return 0;
        }

        $originalEmail = $defaultContact->getEmail();
        if (!$originalEmail) {
            return 0;
        }

        return $this->lifetimeHelper->getNumberOfOrdersAll($originalEmail);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::EXTENSION_NAME;
    }
}
