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
 * @author Jesse Maxwell
 * @copyright Swift Otter Studios, 7/6/15
 * @package default
 **/

namespace JesseMaxwell\PrayerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class FrontendController extends Controller
{
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * @Route("/request/add/{title}", name="_add_request")
     * @Method("GET")
     */
    public function addPrayerRequestAction($title)
    {
        $response = array(
            'success' => true,
            'content' => "Successfully added the request",
            'name'    => $title,
            'you'     => $this->get('request')->get('username')
        );

        return new JsonResponse($response);
    }
}