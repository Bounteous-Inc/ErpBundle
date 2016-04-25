<?php

namespace DemacMedia\Bundle\ErpBundle\Controller;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ErpAccountsController extends Controller
{
    /**
     * @Route("/", name="demacmedia_erp_accounts")
     */
    public function indexAction()
    {
        return $this->render('DemacMediaErpBundle:Default:accounts.html.twig', array(
            'entity_class' => $this->container->getParameter('demacmedia_erp_accounts.entity.class')
        ));
    }


    /**
     * @Route("/view/{id}", name="demacmedia_erp_accounts_view")
     */
    public function viewAction(OroErpAccounts $entity)
    {
        return $this->render('DemacMediaErpBundle:Default:account-view.html.twig', [
            'entity'        => $entity
        ]);
    }


    /**
     * @Route("/create", name="demacmedia_erp_accounts_create")
     * @Template("DemacMediaErpBundle:Default:accounts-update.html.twig")
     */
    public function createAction()
    {
        $formAction = $this->get('oro_entity.routing_helper')
            ->generateUrlByRequest('demacmedia_erp_accounts_create', $this->getRequest());
        $erpAccounts = new OroErpAccounts();
        return $this->update($erpAccounts, $formAction);
    }


    /**
     * @Route("/update/{id}", name="demacmedia_erp_accounts_update", requirements={"id"="\d+"})
     * @Template
     */
    public function updateAction(OroErpAccounts $entity)
    {
        $formAction = $this->get('router')->generate('demacmedia_erp_accounts_update', [
            'id' => (int)$entity->getId()
        ]);

        return $this->update($entity, $formAction);
    }


    /**
     * @Route("/delete/{id}", name="demacmedia_erp_accounts_delete", requirements={"id"="\d+"})
     */
    public function deleteAction($id)
    {

    }


    /**
     * @param OroErpAccounts   $entity
     * @param string $formAction
     *
     * @return array
     */
    protected function update(OroErpAccounts $entity, $formAction)
    {
        $saved = false;

        if ($this->get('demacmedia_erp_accounts_simple.form.handler')->process($entity)) {
            if (!$this->getRequest()->get('_widgetContainer')) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('demacmedia_erp_accounts_simple.controller.saved.message')
                );

                return $this->get('oro_ui.router')->redirectAfterSave(
                    ['route' => 'demacmedia_erp_accounts_update', 'parameters' => ['id' => $entity->getId()]],
                    ['route' => 'demacmedia_erp_accounts'],
                    $entity
                );
            }
            $saved = true;
        }

        return array(
            'entity'     => $entity,
            'saved'      => $saved,
            'form'       => $this->get('demacmedia_erp_accounts_simple.form.handler')->getForm()->createView(),
            'formAction' => $formAction
        );
    }
}
