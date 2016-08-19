<?php

namespace DemacMedia\Bundle\ErpBundle\EventListener;

use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class KernelTerminateListener
{
    protected $containerInterface;

    public function __construct(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }

    /**
     * @param PostResponseEvent $postResponseEvent
     */
    public function terminate(PostResponseEvent $postResponseEvent)
    {
        $status = $postResponseEvent->getResponse()->getStatusCode();
        $route = $postResponseEvent->getRequest()->attributes->get('_route');

        if ('demacmedia_api_erp_create_order' == $route && (201 == $status || 200 == $status)) {
            $lifetimeHelper = $this->containerInterface->get('demacmedia_erp.lifetime_helper');

            $lifetimeHelper->updateLifetimeSalesValue(
                $this->getRequestParameter($postResponseEvent, 'erpaccount'),
                $this->getRequestParameter($postResponseEvent, 'original_email'),
                $this->getRequestParameter($postResponseEvent, 'total_paid')
            );
        } else {
            return;
        }
    }

    public function getRequestParameter($request, $parameter)
    {
        return $request->getRequest()->get($parameter);
    }
}
