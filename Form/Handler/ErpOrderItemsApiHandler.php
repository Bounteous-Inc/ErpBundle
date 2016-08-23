<?php
namespace DemacMedia\Bundle\ErpBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrderItems;

class ErpOrderItemsApiHandler
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     *
     * @param FormInterface $form
     * @param Request       $request
     * @param ObjectManager $manager
     */
    public function __construct(FormInterface $form, Request $request, ObjectManager $manager)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->manager = $manager;
    }

    /**
     * Process form
     *
     * @param  OroErpOrderItems $entity
     * @return bool True on successful processing, false otherwise
     */
    public function process(OroErpOrderItems $entity)
    {
        $this->form->setData($entity);

        if (in_array($this->request->getMethod(), array('POST', 'PUT'))) {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($entity);

                return true;
            }
        }

        return false;
    }

    /**
     * "Success" form handler
     *
     * @param OroErpOrderItems $entity
     */
    protected function onSuccess(OroErpOrderItems $entity)
    {
        $erpOrderEntity = $this
            ->manager
            ->getRepository('DemacMediaErpBundle:OroErpOrders')
            ->find($entity->getOrder());

        $entity->setOrder($erpOrderEntity);

        $this->manager->persist($entity);
        $this->manager->flush();
    }
}
