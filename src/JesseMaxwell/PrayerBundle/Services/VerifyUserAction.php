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

use Doctrine\ORM\EntityManager;
use JesseMaxwell\PrayerBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class VerifyUserAction
{
    protected $em;
    protected $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('JesseMaxwellPrayerBundle:PrayerRequest');
    }

    public function verifyUserPrayerRequestRelationship(User $user, $id)
    {
        $prayerRequest = $this->em->getRepository(
            'JesseMaxwellPrayerBundle:PrayerRequest'
        )->find($id);

        if ($prayerRequest && $user->getId() !== $prayerRequest->getUserId()) {
            throw new AccessDeniedException(
                'Sorry, you can not update id ' . $id
            );
        }
    }
}