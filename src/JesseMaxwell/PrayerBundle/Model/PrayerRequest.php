<?php

namespace JesseMaxwell\PrayerBundle\Model;

use JesseMaxwell\PrayerBundle\Model\om\BasePrayerRequest;

class PrayerRequest extends BasePrayerRequest
{
    public function getDate($format = null)
    {
        return parent::getDate('m-d-Y');
    }

    public function setDate($v = null)
    {
        $v = $v ? $v : new \DateTime();
        parent::setDate($v);
    }
}
