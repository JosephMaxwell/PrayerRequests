<?php

namespace JesseMaxwell\PrayerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }

    public function testAddRequest()
    {
        $client = $this->createClient();

        $client->request('GET', '/request/add');

        $response = $client->getResponse();

        $data = json_decode($response->getContent(), true);

        $this->assertTrue($data['success']);
    }
}
