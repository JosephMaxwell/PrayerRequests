<?php

namespace JesseMaxwell\PrayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_index")
     */
    public function indexAction()
    {
        $response = array(
            "success" => "Hello! You have successfully reached the PrayerRequest API for your frontend application. If you have a valid username or API key, you can use this API to save and manage your prayer requests. Have an awesome day coding!"
        );

        return new JsonResponse($response);
    }
}
