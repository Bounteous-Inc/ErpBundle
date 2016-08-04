<?php

namespace DemacMedia\Bundle\ErpBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpCarts;

class ErpCartsController extends Controller
{
    /**
     * @Route("/", name="demacmedia_erp_carts")
     */
    public function indexAction()
    {
        return $this->render('DemacMediaErpBundle:Default:carts.html.twig', [
            'entity_class' => $this->container->getParameter('demacmedia_erp_carts.entity.class')
        ]);
    }


    /**
     * @Route("/view/{id}", name="demacmedia_erp_carts_view")
     */
    public function viewAction($id, OroErpCarts $entityCarts)
    {
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $entityAccounts = $this->em->getRepository('DemacMediaErpBundle:OroErpAccounts')
            ->findOneBy([
                'originalEmail' => $entityCarts->getOriginalEmail()
            ]);

        if (!$entityAccounts) {
            // throw new EntityNotFoundException();
            printf('There is no accounts for this cart: %d', $id);
            die();
        }

        return $this->render('DemacMediaErpBundle:Default:carts-specific-view.html.twig', [
            'entityAccounts'  => $entityAccounts,
            'entity'          => $entityCarts,
            'cartNumber'     => $id
        ]);
    }


    /**
     * @Route("/create", name="demacmedia_erp_carts_create")
     * @Template("DemacMediaErpBundle:Default:carts-update.html.twig")
     */
    public function createAction()
    {
        $formAction = $this->get('oro_entity.routing_helper')
            ->generateUrlByRequest('demacmedia_erp_carts_create', $this->getRequest());
        $erpCarts = new OroErpCarts();
        return $this->update($erpCarts, $formAction);
    }


    /**
     * @Route("/update/{id}", name="demacmedia_erp_carts_update", requirements={"id"="\d+"})
     * @Template
     */
    public function updateAction(OroErpCarts $entity)
    {
        $formAction = $this->get('router')->generate('demacmedia_erp_carts_update', ['id' => $entity->getId()]);

        return $this->update($entity, $formAction);
    }


    /**
     * @Route("/delete/{id}", name="demacmedia_erp_carts_delete", requirements={"id"="\d+"})
     */
    public function deleteAction($id)
    {

    }


    /**
     * @param OroErpCarts   $entity
     * @param string $formAction
     *
     * @return array
     */
    protected function update(OroErpCarts $entity, $formAction)
    {
        $saved = false;

        if ($this->get('demacmedia_erp_carts_simple.form.handler')->process($entity)) {
            if (!$this->getRequest()->get('_widgetContainer')) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('demacmedia_erp_carts_simple.controller.saved.message')
                );

                return $this->get('oro_ui.router')->redirectAfterSave(
                    ['route' => 'demacmedia_erp_carts_update', 'parameters' => ['id' => $entity->getId()]],
                    ['route' => 'demacmedia_erp_carts'],
                    $entity
                );
            }
            $saved = true;
        }

        return array(
            'entity'     => $entity,
            'saved'      => $saved,
            'form'       => $this->get('demacmedia_erp_carts_simple.form.handler')->getForm()->createView(),
            'formAction' => $formAction
        );
    }
}
