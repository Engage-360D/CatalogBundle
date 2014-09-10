<?php

/*
 * This file is part of the Engage360d Catalog Bundle
 *
 * (c) Aliocha Ryzhkov <alioch@yandex.ru>
 */

namespace Engage360d\Bundle\CatalogBundle\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecordControllerTest extends WebTestCase
{
    /**
     * Creates test Catalog to use in the following tests
     *
     * @return \stdClass
     */
    public function testCreateAuxCatalog()
    {
        $client = static::createClient();
        $client->request('POST', '/api/catalogs', array(
            'engage360d_catalog' => array(
                'id' => 'autoTestRecordCatalogId',
                'name' => 'Auto test catalog name',
            )
        ));

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        return $jsonResponse;
    }

    /**
     * @depends testCreateAuxCatalog
     *
     * @param \stdClass
     * @return int
     */
    public function testGetAll($catalog)
    {
        $client = static::createClient();
        $client->request('GET', '/api/records', array('catalogId' => $catalog->id));

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        return count($jsonResponse);
    }

    /**
     * @depends testCreateAuxCatalog
     *
     * @param \stdClass
     * @return \stdClass
     */
    public function testPost($catalog)
    {
        $client = static::createClient();
        $client->request('POST', '/api/records', array(
            'engage360d_catalog_record' => array(
                'catalog'   => $catalog->id,
                'data'      => 'Test record data',
                'keyword'   => 'testRecordKeyword',
                'order'     => 1,
            )
        ));

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        return $jsonResponse;
    }

    /**
     * @depends testCreateAuxCatalog
     * @depends testGetAll
     *
     * @param \stdClass $catalog
     * @param int $count
     * @return int
     */
    public function testCountIncremented($catalog, $count)
    {
        $client = static::createClient();
        $client->request('GET', '/api/records', array('catalogId' => $catalog->id));

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
        $client->request('GET', '/api/records/' . $object->id);

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($object->catalog->id, $jsonResponse->catalog->id);
        $this->assertEquals($object->data, $jsonResponse->data);
        $this->assertEquals($object->keyword, $jsonResponse->keyword);
        $this->assertEquals($object->order, $jsonResponse->order);
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
        $client->request('PUT', '/api/records/' . $object->id, array(
            'engage360d_catalog_record' => array(
                'catalog'   => $object->catalog->id,
                'data'      => 'UPD. Test record data',
                'keyword'   => 'updTestRecordKeyword',
                'order'     => 2,
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
        $client->request('GET', '/api/records/' . $object->id);

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($object->catalog->id, $jsonResponse->catalog->id);
        $this->assertEquals($object->catalog->name, $jsonResponse->catalog->name);
        $this->assertEquals($object->data, $jsonResponse->data);
        $this->assertEquals($object->keyword, $jsonResponse->keyword);
        $this->assertEquals($object->order, $jsonResponse->order);
    }

    /**
     * @depends testPost
     *
     * @param \stdClass $object
     */
    public function testDelete($object)
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/records/' . $object->id);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check that object has been deleted
        $client->request('GET', '/api/records/' . $object->id);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @depends testCreateAuxCatalog
     * @depends testCountIncremented
     *
     * @param \stdClass $catalog
     * @param int $count The number of objects after adding the new one
     */
    public function testCountDecremented($catalog, $count)
    {
        $client = static::createClient();
        $client->request('GET', '/api/records', array('catalogId' => $catalog->id));

        $jsonResponse = json_decode($client->getResponse()->getContent());
        $this->assertTrue($jsonResponse !== null);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($count - 1, count($jsonResponse));
    }

    /**
     * @depends testCreateAuxCatalog
     *
     * @param \stdClass
     */
    public function testDeleteAux($object)
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/catalogs/' . $object->id);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check that object has been deleted
        $client->request('GET', '/api/catalogs/' . $object->id);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}