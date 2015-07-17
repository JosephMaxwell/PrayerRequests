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
 * @copyright Swift Otter Studios, 7/13/15
 * @package   default
 **/

namespace JesseMaxwell\PrayerBundle\EventListener\Authorization;


use JesseMaxwell\PrayerBundle\Model\UserQuery;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyUsernameListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $currentUser = $event->getRequest()->attributes->get('username');
        $authUser = UserQuery::create()->findOneByUsername($currentUser);

        if (!$authUser && $currentUser) {
            throw new HttpException(401, "I'm sorry, but you are not authorized to access the system.");
        }

        if ($currentUser && !$authUser->getEnabled()) {
            throw new HttpException(403, "I'm sorry, but your account has been disabled. Please contact an administrator and request that they enable your account");
        }
    }
}