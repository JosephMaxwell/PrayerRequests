<?php

namespace JesseMaxwell\PrayerBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\View\View;
use JesseMaxwell\PrayerBundle\Form\Type\PrayerRequestType;
use JesseMaxwell\PrayerBundle\Model\PrayerRequest;
use JesseMaxwell\PrayerBundle\Model\PrayerRequestQuery;
use JesseMaxwell\PrayerBundle\Model\UserQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class ActionController extends FOSRestController
{
    /**
     * @ApiDoc(
     *      section="Actions",
     *      description="Persists a prayer request to the database.",
     *      requirements={
     *          {
     *              "name"="username",
     *              "dataType"="string",
     *              "description"="Provided username to verify authenticity of the request."
     *          }
     *      },
     *      input="JesseMaxwell\PrayerBundle\Form\Type\PrayerRequestType",
     *      statusCodes={
     *          201="Returned when successful, with location of saved request provided.",
     *          400="Returned when an invalid request was received.",
     *          403="Returned when the specified prayer request isn't associated with the user which requested it.",
     *          409="Returned when there is an prayer request with an identical name already associated with the user."
     *      }
     * )
     *
     * @Rest\View()
     * @Route("/request/new", name="_new_request")
     * @Method("PUT")
     */
    public function newRequestAction()
    {
        return $this->processForm(new PrayerRequest());
    }

    /**
     * @ApiDoc(
     *      section="Actions",
     *      description="Updates a prayer request entity.",
     *      requirements={
     *          {
     *              "name"="username",
     *              "dataType"="string",
     *              "description"="Provided username to verify authenticity of the request."
     *          },
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="ID of prayer request to update."
     *          }
     *      },
     *      input="JesseMaxwell\PrayerBundle\Form\Type\PrayerRequestType",
     *      statusCodes={
     *          204="Returned when the prayer request was updated successfully.",
     *          400="Returned when an invalid request was received.",
     *          403="Returned when the specified prayer request isn't associated with the user which requested it.",
     *          404="Returned when the specified prayer request wasn't found.",
     *          409="Returned when there is an prayer request with an identical name already associated with the user."
     *      }
     * )
     *
     * @Rest\View()
     * @Route("/request/update/{id}", name="_update_request", requirements={"id": "\d+"})
     * @Method("PUT")
     */
    public function updateRequestAction($id)
    {
        $prayerRequest = PrayerRequestQuery::create()->findOneById($id);

        if ($prayerRequest === null) {
            throw new NotFoundHttpException("The prayer request that you are looking for wasn't found.");
        }

        $this->get('prayer.verify_action')->verifyPrayerRequestRelationship($prayerRequest);

        return $this->processForm($prayerRequest);
    }

    /**
     * @ApiDoc(
     *      section="Actions",
     *      description="Removes a prayer request entity from the database.",
     *      requirements={
     *          {
     *              "name"="username",
     *              "dataType"="string",
     *              "description"="Provided username to verify authenticity of the request."
     *          },
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="ID of prayer request to delete"
     *          }
     *      },
     *      statusCodes={
     *          204="Returned when model successfully deleted.",
     *          403="Returned when the specified prayer request isn't associated with the user which requested it.",
     *          404="Returned when the specified prayer request wasn't found."
     *      }
     * )
     *
     * @Rest\View(statusCode=204)
     * @Route("/request/delete/{id}", name="_delete_request", requirements={"id": "\d+"})
     * @Method("DELETE")
     */
    public function deleteRequestAction($id)
    {
        $prayerRequest = PrayerRequestQuery::create()->findOneById($id);

        if (!$prayerRequest) {
            throw new NotFoundHttpException("The prayer request that you tried to delete wasn't found.");
        }

        $this->get('prayer.verify_action')->verifyPrayerRequestRelationship($prayerRequest);

        $prayerRequest->delete();
    }

    /**
     * @param \JesseMaxwell\PrayerBundle\Model\PrayerRequest $prayerRequest
     *
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \PropelException
     */
    private function processForm(PrayerRequest $prayerRequest)
    {
        $request = $this->get('request');
        $userId = UserQuery::create()->findIdByUsername($request->get('username'));
        $statusCode = $prayerRequest->isNew() ? 201 : 204;

        $form = $this->createForm(new PrayerRequestType(), $prayerRequest, array('method' => 'PUT'));
        $form->handleRequest($request);

        $prayerRequest->setUserId($userId);
        if ($form->isValid()) {
            $prayerRequest->save();

            $response = new Response();
            $response->setStatusCode($statusCode);

            if ($statusCode === 201) {
                $response->headers->set('Location', $this->generateUrl("_get_request", array(
                    'username' => $request->get('username'),
                    'id' =>$prayerRequest->getId()),
                    true));
            }

            return $response;
        }

        return View::create($form, 400);
    }
}
