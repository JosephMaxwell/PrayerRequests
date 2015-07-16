<?php

namespace JesseMaxwell\PrayerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('success', $response);
        $this->assertContains("PrayerRequest", $response['success']);
    }
}
