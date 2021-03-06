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
 * @copyright Swift Otter Studios, 7/14/15
 * @package   default
 **/

namespace JesseMaxwell\PrayerBundle\Services;

use JesseMaxwell\PrayerBundle\Model\PrayerRequest;
use JesseMaxwell\PrayerBundle\Model\UserQuery;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyUserAction
{
    protected $username;

    public function __construct(RequestStack $requestStack)
    {
        $this->username = $requestStack->getCurrentRequest()->attributes->get('username');
    }

    /**
     * @param \JesseMaxwell\PrayerBundle\Model\PrayerRequest $prayerRequest
     */
    public function verifyPrayerRequestRelationship(PrayerRequest $prayerRequest)
    {
        $user = UserQuery::create()->findOneByUsername($this->username);

        if ($prayerRequest && $user->getId() !== $prayerRequest->getUserId()) {
            throw new HttpException(403, 'You are not allowed to access that prayer request.');
        }
    }
}