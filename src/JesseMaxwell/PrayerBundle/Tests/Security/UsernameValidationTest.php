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

namespace JesseMaxwell\PrayerBundle\Tests\Security;

use JesseMaxwell\PrayerBundle\Tests\JsonTestCase;

class UsernameValidationTest extends JsonTestCase
{
    public function testDeniedAccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/unauthuser/get/request/all');

        $this->assertJsonResponse($client->getResponse(), 401);
    }
}
