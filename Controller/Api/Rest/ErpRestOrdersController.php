<?php
namespace DemacMedia\Bundle\ErpBundle\Controller\Api\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Oro\Bundle\SoapBundle\Form\Handler\ApiFormHandler;
use Oro\Bundle\CommentBundle\Entity\Manager\CommentApiManager;


use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrders;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;

/**
 * @NamePrefix("demacmedia_api_")
 */
class ErpRestOrdersController extends RestController implements ClassResourceInterface
{
    /**
     * REST GET list of Erp Orders
     *
    $response = $oroClient->get('api/rest/latest/erp/orders.json', [
        'query' => [
            'page'  => 1,
            'limit' => 5,
        ]
    ]);
     *
     * @QueryParam(
     *      name="page",
     *      requirements="\d+",
     *      nullable=true,
     *      description="Page number, starting from 1. Defaults to 1."
     * )
     * @QueryParam(
     *      name="limit",
     *      requirements="\d+", nullable=true,
     *      description="Number of items per page. defaults to 10."
     * )
     * @ApiDoc(
     *      resource=true,
     *      description="Get all Erp Orders",
     * )
     * @AclAncestor("demacmedia_erp_orders")
     * @return Response
     */
    public function cgetAction()
    {
        $page = (int) $this->getRequest()->get('page', 1);
        $limit = (int) $this->getRequest()->get('limit', self::ITEMS_PER_PAGE);

        return $this->handleGetListRequest($page, $limit);
    }


    /**
     * Get specific account data
     *
        // Get a specific account using a id. In this example id=1
        $physicalOrdersResponse = $oroClient->get('api/rest/latest/erp/orders/1.json', []);
     * @param int $id Account id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @ApiDoc(
     * description="Get a specific Physical Store account info",
     * resource=true,
     * requirements={
     * {"name"="id", "dataType"="integer"},
     * }
     * )
     * @AclAncestor("demacmedia_erp_orders_view")
     */
    public function getAction($id)
    {
        return $this->handleGetRequest($id);
    }


    /**
     * Create new Erp Order
     *
     *
        // Example creating a new Web Order.
        $response = $oroClient->post('api/rest/latest/erp/orders/rodolfo.json', [
            'body' => [
                'original_order_id' => '1234',
                'original_email'    => 'example@example.org',
                'total_paid'        => '11.11',
                'website_id'        => 'httpwwwwebsitecom',
                'createdAt'         => 'YYYY-mm-dd HH:ii:ss',
                'updatedAt'         => 'YYYY-mm-dd HH:ii:ss',
                'bill_firstname'    => 'Example',
                'bill_lastname'     => 'Example',
                'bill_company'      => 'Acme',
                'bill_address1'     => '12 Example Street',
                'bill_address2'     => 'Unit 1',
                'bill_city'         => 'Toronto',
                'bill_state'        => 'ON',
                'bill_zip'          => 'A1A1A1',
                'bill_phone'        => '+1(111) 111-1111',
                'ship_firstname'    => 'Example',
                'ship_lastname'     => 'Example',
                'ship_company'      => 'Acme',
                'ship_address1'     => '11 Example Street',
                'ship_address2'     => 'Unit 11',
                'ship_city'         => 'Toronto',
                'ship_state'        => 'ON',
                'ship_zip'          => 'A1A1A1',
                'ship_phone'        => '+1(111) 111-1111',
                'owner'             => '1', // OroCRM User ID
            ]
        ]);
     *
     * @param string $originalEmail original_email
     *
     * @ApiDoc(
     * description="Create new Physical Store Account.",
     * resource=true
     * )
     * @AclAncestor("demacmedia_erp_orders_create")
     *
     * @return Response
     */
    public function postAction($originalEmail, Request $request)
    {
        $account = $this->getDoctrine()->getManager()->getRepository('DemacMediaErpBundle:OroErpAccounts')->findOneBy([
            'originalEmail' => $originalEmail
        ]);
        $isProcessed = false;
        $order = new OroErpOrders();

        if ($account instanceof OroErpAccounts) {
            $order->setOriginalEmail($account);

            $form = $this->getForm();
            $form->handleRequest($request);

            $entity = $form->getViewData();
            $entity->setOriginalEmail($account);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->persist($entity);
                $this->getDoctrine()->getManager()->flush();
                $view = $this->view($this->createResponseData($entity), Codes::HTTP_CREATED);
                $isProcessed = true;
            } else {
                $view = $this->view($this->getForm(), Codes::HTTP_BAD_REQUEST);
            }
        } else {
            $view = $this->view($this->getForm(), Codes::HTTP_NOT_FOUND);
        }
        return $this->buildResponse($view, self::ACTION_CREATE, ['success' => $isProcessed, 'entity' => $entity]);
    }


    /**
     * Update Physical Store account
     *
        $request = $oroClient->put('api/rest/latest/erp/orders/6.json', [
            'body' => [
                'original_order_id' => '1234',
                'original_email'    => 'example@example.org',
                'total_paid'        => '11.11',
                'website_id'        => 'httpwwwwebsitecom',
                'createdAt'         => 'YYYY-mm-dd HH:ii:ss',
                'updatedAt'         => 'YYYY-mm-dd HH:ii:ss',
                'bill_firstname'    => 'Example',
                'bill_lastname'     => 'Example',
                'bill_company'      => 'Acme',
                'bill_address1'     => '12 Example Street',
                'bill_address2'     => 'Unit 1',
                'bill_city'         => 'Toronto',
                'bill_state'        => 'ON',
                'bill_zip'          => 'A1A1A1',
                'bill_phone'        => '+1(111) 111-1111',
                'ship_firstname'    => 'Example',
                'ship_lastname'     => 'Example',
                'ship_company'      => 'Acme',
                'ship_address1'     => '11 Example Street',
                'ship_address2'     => 'Unit 11',
                'ship_city'         => 'Toronto',
                'ship_state'        => 'ON',
                'ship_zip'          => 'A1A1A1',
                'ship_phone'        => '+1(111) 111-1111',
                'owner'             => '1', // OroCRM User ID
            ]
        ]);
     *
     * @param int $id Comment item id
     *
     * @ApiDoc(
     * description="Update Physical Store account",
     * resource=true
     * )
     * @AclAncestor("demacmedia_erp_orders_update")
     *
     * @return Response
     */
    public function putAction($id)
    {
        return $this->handleUpdateRequest($id);
    }


    /**
     * Delete Physical Store account
     *
        // Example deleting Account with id: 1
        $response = $oroClient->delete('api/rest/latest/erp/orders/1.json');
     *
     * @param int $id comment id
     *
     * @ApiDoc(
     *      description="Delete Erp account",
     *      resource=true
     * )
     * @Acl(
     * id="demacmedia_erp_orders_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="DemacMediaErpBundle:OroErpOrders"
     * )
     * @return Response
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }



    /**
     * Get entity Manager
     *
     * @return ApiEntityManager
     */
    public function getManager()
    {
        return $this->get('demacmedia_erp_orders.manager.api');
    }


    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->get('demacmedia_erp_orders.form.orders.api');
    }


    /**
     * @return ApiFormHandler
     */
    public function getFormHandler()
    {
        return $this->get('demacmedia_erp_orders.form.handler.orders_api');
    }
}
