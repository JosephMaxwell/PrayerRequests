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


class ActionController extends FOSRestController
{
    /**
     * @Rest\View()
     * @Route("/request/new", name="_new_request")
     * @Method("PUT")
     */
    public function newRequestAction()
    {
        return $this->processForm(new PrayerRequest());
    }

    /**
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

        return $this->processForm($prayerRequest);
    }

    /**
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
