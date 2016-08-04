<?php

namespace DemacMedia\Bundle\ErpBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpCartItems;

class ErpCartItemsController extends Controller
{
    /**
     * @Route("/", name="demacmedia_erp_cart_items")
     */
    public function indexAction()
    {
        return $this->render('DemacMediaErpBundle:Default:cart_items.html.twig', array(
            'entity_class' => $this->container->getParameter('demacmedia_erp_cart_items.entity.class')
        ));
    }


    /**
     * @Route("/view/{id}", name="demacmedia_erp_cart_items")
     */
    public function viewAction($originalCartId, OroErpCartItems $entity)
    {
        return $this->render('DemacMediaErpBundle:Default:cart-view.html.twig', [
            'entity' => $entity,
            'originalCartId' => $originalCartId
        ]);
    }


    /**
     * @Route("/create", name="demacmedia_erp_cart_items_create")
     * @Template("DemacMediaErpBundle:Default:cart_items-update.html.twig")
     */
    public function createAction()
    {
        $formAction = $this->get('oro_entity.routing_helper')
            ->generateUrlByRequest('demacmedia_erp_cart_items_create', $this->getRequest());
        $erpCartItems = new OroErpCartItems();
        return $this->update($erpCartItems, $formAction);
    }


    /**
     * @Route("/update/{id}", name="demacmedia_erp_cart_items_update", requirements={"id"="\d+"})
     * @Template
     */
    public function updateAction(OroErpCartItems $entity)
    {
        $formAction = $this->get('router')->generate('demacmedia_erp_cart_items_update', ['id' => $entity->getId()]);

        return $this->update($entity, $formAction);
    }


    /**
     * @Route("/delete/{id}", name="demacmedia_erp_cart_items_delete", requirements={"id"="\d+"})
     */
    public function deleteAction($id)
    {

    }


    /**
     * @param OroErpCartItems   $entity
     * @param string $formAction
     *
     * @return array
     */
    protected function update(OroErpCartItems $entity, $formAction)
    {
        $saved = false;

        if ($this->get('demacmedia_erp_cart_items_simple.form.handler')->process($entity)) {
            if (!$this->getRequest()->get('_widgetContainer')) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('demacmedia_erp_cart_items_simple.controller.saved.message')
                );

                return $this->get('oro_ui.router')->redirectAfterSave(
                    ['route' => 'demacmedia_erp_cart_items_update', 'parameters' => ['id' => $entity->getId()]],
                    ['route' => 'demacmedia_erp_cart_items'],
                    $entity
                );
            }
            $saved = true;
        }

        return array(
            'entity'     => $entity,
            'saved'      => $saved,
            'form'       => $this->get('demacmedia_erp_cart_items_simple.form.handler')->getForm()->createView(),
            'formAction' => $formAction
        );
    }
}
