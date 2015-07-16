<?php

namespace JesseMaxwell\PrayerBundle\Model;

use JesseMaxwell\PrayerBundle\Model\om\BasePrayerRequestQuery;

class PrayerRequestQuery extends BasePrayerRequestQuery
{
    public function findIfUserHasRequest($request, $userId)
    {
        $prayerRequest = $this->findByTitle($request);
        $matchFound = false;

        foreach ($prayerRequest as $request) {
            if ($request->getUserId() === $userId) {
                $matchFound = true;
            }
        }

        return $matchFound;
    }
}
