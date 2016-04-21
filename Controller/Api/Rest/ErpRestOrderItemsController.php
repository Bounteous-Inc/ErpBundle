<?php
namespace DemacMedia\Bundle\ErpBundle\Controller\Api\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Oro\Bundle\SoapBundle\Form\Handler\ApiFormHandler;

use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrders;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpOrderItems;



/**
 * @NamePrefix("demacmedia_api_")
 */
class ErpRestOrderItemsController extends RestController implements ClassResourceInterface
{
    /**
     * REST GET list of Physical Store OrderItems
     *
    $physicalOrderItemsResponse = $oroClient->get('api/rest/latest/erp/orderitems.json', [
        'query' => [
            'page' => 1,
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
     *      description="Get all Physical Store OrderItems",
     * )
     * @AclAncestor("demacmedia_erp_orderitems")
     * @return Response
     */
    public function cgetAction()
    {
        $page = (int) $this->getRequest()->get('page', 1);
        $limit = (int) $this->getRequest()->get('limit', self::ITEMS_PER_PAGE);

        return $this->handleGetListRequest($page, $limit);
    }


    /**
     * Get specific order items data
     *
    // Get a specific order items using a id. In this example id=1
    $physicalOrderItemsResponse = $oroClient->get('api/rest/latest/erp/orderitems/1.json', []);
     * @param int $id Account id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @ApiDoc(
     * description="Get a specific Physical Store order items info",
     * resource=true,
     * requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer"},
     *      }
     * )
     * @AclAncestor("demacmedia_erp_orderitems_view")
     */
    public function getAction($id)
    {
        return $this->handleGetRequest($id);
    }


    /**
     * Create new Physical Store Order Items
     *
    // Example creating a new Order Items.
    $response = $oroClient->post(
    'api/rest/latest/erp/orderitems.json', [
        'body' => [
            'invno'     => $csvLine['invno'], // Required
            'custno'    => $csvLine['custno'], // Required
            'item'      => $csvLine['item'],
            'descrip'   => $csvLine['descrip'],
            'taxrate'   => $csvLine['taxrate'],
            'cost'      => $csvLine['cost'],
            'price'     => $csvLine['price'],
            'qtyord'    => $csvLine['qtyord'],
            'qtyshp'    => $csvLine['qtyshp'],
            'extprice'  => $csvLine['extprice'],
            'invdate'   => $csvLine['invdate'],
            'ponum'     => $csvLine['ponum'],
        ]
        ]
    );
     *
     * @ApiDoc(
     * description="Create new Physical Store Order Items.",
     * resource=true
     * )
     * @AclAncestor("demacmedia_erp_orderitems_create")
     */
    public function postAction()
    {
        return $this->handleCreateRequest();
    }



    /**
     * Update Physical Store order items
     *
     * @param int $id Comment item id
     *
     * @ApiDoc(
     * description="Update Physical Store order items",
     * resource=true
     * )
     * @AclAncestor("demacmedia_erp_orderitems_update")
     *
     * @return Response
     */
    public function putAction($id)
    {
        return $this->handleUpdateRequest($id);
    }


    /**
     * Delete Physical Store order items
     *
    // Example deleting Order Items with id: 1
    $response = $oroClient->delete('api/rest/latest/erp/orderitems/1.json');
     *
     * @param int $id comment id
     *
     * @ApiDoc(
     * description="Delete Physical Store order items",
     * resource=true
     * )
     * @Acl(
     * id="demacmedia_erp_order_items_delete",
     * type="entity",
     * permission="DELETE",
     * class="DemacMediaErpBundle:OroErpOrderItems"
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
        return $this->get('demacmedia_erp_orderitems.manager.api');
    }


    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->get('demacmedia_erp_orderitems.form.orderitems.api');
    }


    /**
     * @return ApiFormHandler
     */
    public function getFormHandler()
    {
        return $this->get('demacmedia_erp_orderitems.form.handler.orderitems_api');
    }
}
