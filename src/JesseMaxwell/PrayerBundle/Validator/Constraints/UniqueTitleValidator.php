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

namespace JesseMaxwell\PrayerBundle\Validator\Constraints;


use JesseMaxwell\PrayerBundle\Model\PrayerRequestQuery;
use JesseMaxwell\PrayerBundle\Model\UserQuery;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueTitleValidator extends ConstraintValidator
{
    protected $username;

    public function __construct(RequestStack $requestStack)
    {
        $this->username = $requestStack->getCurrentRequest()->attributes->get('username');
    }

    public function validate($value, Constraint $context)
    {
        $userId = UserQuery::create()->findIdByUsername($this->username);
        $matchFound = PrayerRequestQuery::create()->findIfUserHasRequest($value, $userId);

        if ($matchFound) {
            throw new HttpException(409, "You already have a prayer request titled that.");
        }
    }
}