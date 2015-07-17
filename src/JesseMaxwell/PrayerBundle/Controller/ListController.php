<?php

namespace JesseMaxwell\PrayerBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use JesseMaxwell\PrayerBundle\Model\PrayerRequestQuery;
use JesseMaxwell\PrayerBundle\Model\UserQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ListController extends FOSRestController
{
    /**
     * @ApiDoc(
     *      section="Request",
     *      description="Returns a list of all a users requests",
     *      requirements={
     *          {
     *              "name"="username",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="Provided username to verify authenticity of the request."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *          404="Returned when no prayer prayer requests are associated with that user"
     *      }
     * )
     *
     * @Rest\View()
     * @Route("/request/all", name="_get_all_requests")
     * @Method("GET")
     */
    public function getAllRequestsAction()
    {
        $userId = UserQuery::create()->findOneByUsername($this->get('request')->attributes->get('username'))->getId();
        $prayerRequests = PrayerRequestQuery::create()->findByUserId($userId);

        if (!$prayerRequests) {
            throw new NotFoundHttpException("No prayer requests found.");
        }

        return array('prayer_requests' => $prayerRequests->toArray());
    }

    /**
     * @ApiDoc(
     *      section="Request",
     *      description="Returns the prayer request the user requested.",
     *      requirements={
     *          {
     *              "name"="username",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="Provided username to verify authenticity of the request."
     *          },
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="ID of prayer request to return"
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *          404="Returned when the specified prayer request wasn't found.",
     *          403="Returned when the specified prayer request isn't associated with the user which requested it"
     *      }
     * )
     * @Rest\View()
     * @Route("/request/{id}", name="_get_request", requirements={"id": "\d+"})
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
