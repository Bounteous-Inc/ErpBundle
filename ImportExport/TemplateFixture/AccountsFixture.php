<?php

namespace DemacMedia\Bundle\ErpBundle\ImportExport\TemplateFixture;

use Oro\Bundle\ImportExportBundle\TemplateFixture\AbstractTemplateRepository;
use Oro\Bundle\ImportExportBundle\TemplateFixture\TemplateFixtureInterface;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;

class AccountsFixture extends AbstractTemplateRepository implements TemplateFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return 'Oro\Bundle\ErpBundle\Entity\OroErpAccounts';
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->getEntityData('Neil Armstrong');
    }

    /**
     * {@inheritdoc}
     */
    protected function createEntity($key)
    {
        return new OroErpAccounts();
    }

    /**
     * @param string $key
     * @param OroErpAccounts   $entity
     */
    public function fillEntityData($key, $entity)
    {
        $userRepo = $this->templateManager
            ->getEntityRepository('Oro\Bundle\UserBundle\Entity\User');
        $organizationRepo = $this->templateManager
            ->getEntityRepository('Oro\Bundle\OrganizationBundle\Entity\Organization');


        switch ($key) {
            case 'John Doo':
                $entity
                    ->setId('1')
                    ->setCustno('100')
                    ->setCompany('Acme')
                    ->setContact('Neil Armstrong')
                    ->setTitle('Dr')
                    ->setAddress1('Moon street, 123')
                    ->setAddress2('Apartment 10')
                    ->setCity('Moon City')
                    ->setCountry('United States')
                    ->setZip('999 999')
                    ->setPhone('999 999-9999')
                    ->setPhone2('888 888-8888')
                    ->setSource('Source Name')
                    ->setType('Type Name')
                    ->setEmail('email@example.org')
                    ->setCustmemo('Custom memo')
                    ->setUrl('http://www.example.org')
                    ->setCreated(new \DateTime())
                    ->setUpdated(new \DateTime())
                    ->setOwner($userRepo->getEntity('Neil Armstrong'))
                    ->setOrganization($organizationRepo->getEntity('default'));
                return;
        }

        parent::fillEntityData($key, $entity);
    }
}
