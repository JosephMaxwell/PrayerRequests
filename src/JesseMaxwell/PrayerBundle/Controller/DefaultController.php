<?php

namespace JesseMaxwell\PrayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_index")
     */
    public function indexAction()
    {
        return $this->render('JesseMaxwellPrayerBundle:Default:index.html.twig');
    }
}
