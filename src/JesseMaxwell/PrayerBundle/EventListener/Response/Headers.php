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
 * @copyright Swift Otter Studios, 7/21/15
 * @package   default
 **/

namespace JesseMaxwell\PrayerBundle\EventListener\Response;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class Headers
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $referer = $event->getRequest()->headers->get('referer');

        $event->getResponse()->headers->set('Access-Control-Allow-Methods', 'GET, PUT, DELETE');

        if ($referer) {
            $event->getResponse()->headers->set('Access-Control-Allow-Origin', $referer);
        }
    }
}