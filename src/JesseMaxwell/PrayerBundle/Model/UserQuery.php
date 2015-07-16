<?php

namespace JesseMaxwell\PrayerBundle\Model;

use JesseMaxwell\PrayerBundle\Model\om\BaseUserQuery;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserQuery extends BaseUserQuery
{
    public function findIdByUsername($username)
    {
        $user = $this->findOneByUsername($username);

        if (!$user) {
            throw new AccessDeniedException('Could not find the user that you asked for.');
        }

        return $user->getId();
    }
}
