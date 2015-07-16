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
 * @copyright Swift Otter Studios, 7/16/15
 * @package   default
 **/
namespace JesseMaxwell\PrayerBundle\Tests\Controller;

use JesseMaxwell\PrayerBundle\Tests\JsonTestCase;

class ActionControllerTest extends JsonTestCase
{
    public function testUserNotDuplicateRequest()
    {
        $client = static::createClient();
        $requestBody = json_encode(array(
            "prayerrequest" => array(
                "title" => "first test",
                "date" => "01-02-2012"
            )
        ));

        $client->request('PUT', '/bassplayer7/request/new', array(), array(), array('CONTENT_TYPE' => 'application/json'), $requestBody);
        $response = $client->getResponse();

        $this->assertEquals(409, $response->getStatusCode());
        $this->assertJsonResponse($response, 409);
    }

    public function testBadRequest()
    {
        $requestBody = json_encode(array(
            "title" => "first test",
            "date" => "01-02-2012"
        ));

        $client = static::createClient();
        $client->request('PUT', '/bassplayer7/request/new', array(), array(), array(), $requestBody);
        $response = $client->getResponse();

        $this->assertJsonResponse($response, 400);
    }

    public function testUserCantDeleteOtherRequest()
    {
        $client = static::createClient();

        $crawler = $client->request('DELETE', '/me/delete/request/3');

        $this->assertJsonResponse($client->getResponse(), 404);
    }
}