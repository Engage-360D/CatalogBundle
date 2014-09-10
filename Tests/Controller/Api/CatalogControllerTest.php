<?php

/*
 * This file is part of the Engage360d Catalog Bundle
 *
 * (c) Aliocha Ryzhkov <alioch@yandex.ru>
 */

namespace Engage360d\Bundle\CatalogBundle\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CatalogControllerTest extends WebTestCase
{
    /**
     * @return int
     */
    public function testGetAll()
    {
        $client = static::createClient();
        $client->request('GET', '/api/catalogs');

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        return count($jsonResponse);
    }

    /**
     * @return \stdClass
     */
    public function testPost()
    {
        $client = static::createClient();
        $client->request('POST', '/api/catalogs', array(
            'engage360d_catalog' => array(
                'id' => 'autoTestCatalogId',
                'name' => 'Auto test catalog name',
            )
        ));

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        return $jsonResponse;
    }

    /**
     * @depends testGetAll
     *
     * @param int $count
     * @return int
     */
    public function testCountIncremented($count)
    {
        $client = static::createClient();
        $client->request('GET', '/api/catalogs');

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($count + 1, count($jsonResponse));

        return count($jsonResponse);
    }

    /**
     * @depends testPost
     *
     * @param \stdClass $object
     */
    public function testGetOne($object)
    {
        $client = static::createClient();
        $client->request('GET', '/api/catalogs/' . $object->id);

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($object->id, $jsonResponse->id);
        $this->assertEquals($object->name, $jsonResponse->name);
    }

    /**
     * @depends testPost
     *
     * @param \stdClass $object
     * @return \stdClass
     */
    public function testPut($object)
    {
        $client = static::createClient();
        $client->request('PUT', '/api/catalogs/' . $object->id, array(
            'engage360d_catalog' => array(
                'id'    => $object->id,
                'name'  => 'UPD. Auto test catalog name',
            )
        ));

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        return $jsonResponse;
    }

    /**
     * @depends testPut
     *
     * @param \stdClass
     */
    public function testChanged($object)
    {
        $client = static::createClient();
        $client->request('GET', '/api/catalogs/' . $object->id);

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($object->id, $jsonResponse->id);
        $this->assertEquals($object->name, $jsonResponse->name);
    }

    /**
     * @depends testPost
     *
     * @param \stdClass $object
     */
    public function testDelete($object)
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/catalogs/' . $object->id);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check that object has been deleted
        $client->request('GET', '/api/catalogs/' . $object->id);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @depends testCountIncremented
     *
     * @param int $count The number of objects after adding the new one
     */
    public function testCountDecremented($count)
    {
        $client = static::createClient();
        $client->request('GET', '/api/catalogs');

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($count - 1, count($jsonResponse));
    }
}
