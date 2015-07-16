<?php

namespace JesseMaxwell\PrayerBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use JesseMaxwell\PrayerBundle\Model\PrayerRequestQuery;
use JesseMaxwell\PrayerBundle\Model\UserQuery;
use Proxies\__CG__\JesseMaxwell\PrayerBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ListController extends FOSRestController
{
    /**
     * @Rest\View()
     * @Route("/get/request/all", name="_get_all_requests")
     * @Method("GET")
     */
    public function getAllRequestsAction()
    {
        $prayerRequests = PrayerRequestQuery::create()->find();

        if (!$prayerRequests) {
            throw new NotFoundHttpException("No prayer requests found.");
        }

        return array('prayer_requests' => $prayerRequests->toArray());
    }

    /**
     * @Rest\View()
     * @Route("/get/request/{id}", name="_get_request", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function getRequestAction($id)
    {
        $prayerRequest = PrayerRequestQuery::create()->findPk((int) $id);

        if (!$prayerRequest) {
            throw new NotFoundHttpException("Prayer request not found");
        }

        $this->get('prayer.verify_action')->verifyPrayerRequestRelationship($prayerRequest);

        return array('prayer_request' => $prayerRequest->toArray());
    }
}
