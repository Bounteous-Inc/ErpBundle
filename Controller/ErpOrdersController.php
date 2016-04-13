<?php

namespace DemacMedia\Bundle\ErpBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrders;

class ErpOrdersController extends Controller
{
    /**
     * @Route("/", name="demacmedia_erp_orders")
     */
    public function indexAction()
    {
        return $this->render('DemacMediaErpBundle:Default:orders.html.twig', [
            'entity_class' => $this->container->getParameter('demacmedia_erp_orders.entity.class')
        ]);
    }


    /**
     * @Route("/view/{originalOrderId}", name="demacmedia_erp_orders_view")
     */
    public function viewAction($originalOrderId, OroErpOrders $entityOrders)
    {
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $entityAccounts = $this->em->getRepository('DemacMediaErpBundle:OroErpAccounts')
            ->findOneBy([
                'originalEmail' => $entityOrders->getOriginalEmail()
            ]);

        if (!$entityAccounts) {
            // throw new EntityNotFoundException();
            printf('There is no accounts for this order: %d', $originalOrderId);
            die();
        }

        return $this->render('DemacMediaErpBundle:Default:orders-specific-view.html.twig', [
            'entityAccounts'  => $entityAccounts,
            'entity'          => $entityOrders,
            'originalOrderId' => $originalOrderId
        ]);
    }


    /**
     * @Route("/create", name="demacmedia_erp_orders_create")
     * @Template("DemacMediaErpBundle:Default:orders-update.html.twig")
     */
    public function createAction()
    {
        $formAction = $this->get('oro_entity.routing_helper')
            ->generateUrlByRequest('demacmedia_erp_orders_create', $this->getRequest());
        $erpOrders = new OroErpOrders();
        return $this->update($erpOrders, $formAction);
    }


    /**
     * @Route("/update/{id}", name="demacmedia_erp_orders_update", requirements={"id"="\d+"})
     * @Template
     */
    public function updateAction(OroErpOrders $entity)
    {
        $formAction = $this->get('router')->generate('demacmedia_erp_orders_update', ['id' => $entity->getId()]);

        return $this->update($entity, $formAction);
    }


    /**
     * @Route("/delete/{id}", name="demacmedia_erp_orders_delete", requirements={"id"="\d+"})
     */
    public function deleteAction($id)
    {

    }


    /**
     * @param OroErpOrders   $entity
     * @param string $formAction
     *
     * @return array
     */
    protected function update(OroErpOrders $entity, $formAction)
    {
        $saved = false;

        if ($this->get('demacmedia_erp_orders_simple.form.handler')->process($entity)) {
            if (!$this->getRequest()->get('_widgetContainer')) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('demacmedia_erp_orders_simple.controller.saved.message')
                );

                return $this->get('oro_ui.router')->redirectAfterSave(
                    ['route' => 'demacmedia_erp_orders_update', 'parameters' => ['id' => $entity->getId()]],
                    ['route' => 'demacmedia_erp_orders'],
                    $entity
                );
            }
            $saved = true;
        }

        return array(
            'entity'     => $entity,
            'saved'      => $saved,
            'form'       => $this->get('demacmedia_erp_orders_simple.form.handler')->getForm()->createView(),
            'formAction' => $formAction
        );
    }
}
