<?php
/**
 * SwiftOtter_Base is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SwiftOtter_Base is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with SwiftOtter_Base. If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright: 2015 (c) SwiftOtter Studios
 *
 * @author    Jesse Maxwell
 * @copyright Swift Otter Studios, 7/15/15
 * @package   default
 **/

namespace JesseMaxwell\PrayerBundle\Tests\Controller;

use JesseMaxwell\PrayerBundle\Tests\JsonTestCase;

class ListControllerTest extends JsonTestCase
{
    public function testDeniedAccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/unauthuser/request/all');

        $this->assertJsonResponse($client->getResponse(), 401);
    }

    public function testGetAllRequests()
    {
        $client = static::createClient();
        $client->request('GET', '/bassplayer7/request/all');

        $this->assertJsonResponse($client->getResponse(), 200);
        $this->assertArrayHasKey(
            "prayer_requests",
            json_decode($client->getResponse()->getContent(), true)
        );
    }

    public function testMethodNotAllowed()
    {
        $client = static::createClient();
        $client->request('POST', '/bassplayer7/request/all');

        $this->assertJsonResponse($client->getResponse(), 405);
    }

    public function testRequestById()
    {
        $client = static::createClient();
        $client->request('GET', '/bassplayer7/request/1');
        $decodedJson = json_decode($client->getResponse()->getContent(), true);

        $this->assertJsonResponse($client->getResponse(), 200);
        $this->assertArrayHasKey("prayer_request", $decodedJson);
        $this->assertEquals(1, $decodedJson['prayer_request']['Id']);
    }

    public function testUserOnlyGetTheirRequests()
    {
        $client = static::createClient();
        $client->request('GET', '/bassplayer7/request/all');
        $response = $client->getResponse();
        $jsonContents = json_decode($response->getContent(), true);

        $this->assertJsonResponse($response, 200);

        foreach ($jsonContents["prayer_requests"] as $request) {
            $this->assertEquals(1, $request["UserId"]);
        }
    }

    public function testUserCantAccessOtherRequest()
    {
        $client = static::createClient();
        $client->request('GET', '/keysplayer8/request/1');

        $this->assertJsonResponse($client->getResponse(), 403);
    }
}