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

namespace JesseMaxwell\PrayerBundle\Entity;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\ParameterBag;

class PrayerRequestPersistenceHandler
{
    protected $em;
    protected $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('JesseMaxwellPrayerBundle:PrayerRequest');
    }

    public function update(ParameterBag $request, $id)
    {
        $prayerRequest = $this->repository->find($id);

        if (!$prayerRequest) {
            throw new EntityNotFoundException(
                'No prayer request found for id ' . $id
            );
        }

        if ($request->get('title')) {
            $prayerRequest->setTitle($request->get('title'));
        }

        if ($request->get('description')) {
            $prayerRequest->setDescription($request->get('description'));
        }

        if ($request->get('date')) {
            $prayerRequest->setDate(new \DateTime($request->get('date')));
        }

        if ($request->get('answered')) {
            $prayerRequest->setAnswered(filter_var($request->get('answered'), FILTER_VALIDATE_BOOLEAN));
        }

        $this->em->flush();
    }

    public function remove($id)
    {
        $prayerRequest = $this->repository->find($id);

        if (!$prayerRequest) {
            throw new EntityNotFoundException(
                'No prayer request found for id ' . $id
            );
        }

        $this->em->remove($prayerRequest);
        $this->em->flush();
    }
}