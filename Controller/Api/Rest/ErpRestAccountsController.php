<?php
namespace DemacMedia\Bundle\ErpBundle\Controller\Api\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Oro\Bundle\SoapBundle\Form\Handler\ApiFormHandler;

/**
 * @NamePrefix("demacmedia_api_")
 */
class ErpRestAccountsController extends RestController implements ClassResourceInterface
{
    /**
     * REST GET list of Erp Accounts
     *
    $response = $oroClient->get('api/rest/latest/erp/accounts.json', [
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
     *      description="Get all Erp Accounts",
     * )
     * @AclAncestor("demacmedia_erp_accounts")
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
    $physicalAccountsResponse = $oroClient->get('api/rest/latest/erp/accounts/1.json', []);
     * @param int $id Account id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @ApiDoc(
     *      description="Get a specific Physical Store account info",
     *      resource=true,
     *      requirements={
     *          {"name"="id", "dataType"="integer"},
     *      }
     * )
     * @AclAncestor("demacmedia_erp_accounts_view")
     */
    public function getAction($id)
    {
        return $this->handleGetRequest($id);
    }


    /**
     * Create new Erp Account
     *
    // Example creating a new Account.
    $response = $oroClient->post('api/rest/latest/erp/accounts.json', [
        'body' => [
            'account_original_id' => '123',
            'first_name'          => 'Example',
            'last_name'           => 'Example',
            'email'               => 'example@example.org',
            'original_email'      => 'example@example.org',
            'website_id'          => 'httpwwwwebsitecom',
            'created_at'          => 'YYYY-mm-dd HH:ii:ss',
            'updated_at'          => 'YYYY-mm-dd HH:ii:ss'
        ]
    ]);
     *
     * @ApiDoc(
     * description="Create new Physical Store Account.",
     * resource=true
     * )
     * @AclAncestor("demacmedia_erp_accounts_create")
     */
    public function postAction()
    {
        return $this->handleCreateRequest();
    }



    /**
     * Update Physical Store account
     *
    $request = $oroClient->put('api/rest/latest/erp/accounts/1.json', [
        'body' => [
            'account_original_id' => '123',
            'first_name'          => 'Example',
            'last_name'           => 'Example',
            'email'               => 'example@example.org',
            'original_email'      => 'example@example.org',
            'website_id'          => 'httpwwwwebsitecom',
            'created_at'          => 'YYYY-mm-dd HH:ii:ss',
            'updated_at'          => 'YYYY-mm-dd HH:ii:ss'
            'owner'               => '1', // This is the OroCRM User ID
        ]
    ]);
     *
     * @param int $id Comment item id
     *
     * @ApiDoc(
     * description="Update Physical Store account",
     * resource=true
     * )
     * @AclAncestor("demacmedia_erp_accounts_update")
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
    $response = $oroClient->delete('api/rest/latest/erp/accounts/1.json');
     *
     * @param int $id comment id
     *
     * @ApiDoc(
     *      description="Delete Erp account",
     *      resource=true
     * )
     * @Acl(
     * id="demacmedia_erp_accounts_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="DemacMediaErpBundle:OroErpAccounts"
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
        return $this->get('demacmedia_erp_accounts.manager.api');
    }


    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->get('demacmedia_erp_accounts.form.accounts.api');
    }


    /**
     * @return ApiFormHandler
     */
    public function getFormHandler()
    {
        return $this->get('demacmedia_erp_accounts.form.handler.accounts_api');
    }
}
