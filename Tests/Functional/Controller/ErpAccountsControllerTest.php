<?php

namespace DemacMedia\Bundle\ErpBundle\Tests\Functional\Controller;

use Symfony\Component\DomCrawler\Crawler;
use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use DemacMedia\Bundle\ErpBundle\Controller\ErpAccountsController;

class ErpAccountsControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
