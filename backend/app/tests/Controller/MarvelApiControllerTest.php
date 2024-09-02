<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MarvelApiControllerTest extends WebTestCase
{
    public function testGetCharactersSuccess()
    {
        $client = static::createClient();
        $client->request('GET', '/api/marvel/characters?limit=20&offset=0');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('code', $responseData);
        $this->assertArrayHasKey('success', $responseData);
        $this->assertArrayHasKey('message', $responseData);

        $this->assertIsArray($responseData['data']);

        $this->assertGreaterThanOrEqual(1, count($responseData['data'])); 
    }


    public function testGetCharactersNoData()
    {
        $client = static::createClient();
        $client->request('GET', '/api/marvel/characters?limit=20&offset=9999999'); 

        $this->assertEquals(200, $client->getResponse()->getStatusCode()); 

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('code', $responseData);
        $this->assertArrayHasKey('success', $responseData);
        $this->assertArrayHasKey('message', $responseData);

        $this->assertIsArray($responseData['data']);
        $this->assertCount(20, $responseData['data']); // Aucun personnage attendu
    }



}
