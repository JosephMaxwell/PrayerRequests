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
 * @author Jesse Maxwell
 * @copyright Swift Otter Studios, 7/6/15
 * @package default
 **/

namespace JesseMaxwell\PrayerBundle\Controller;

use JesseMaxwell\PrayerBundle\Entity\PrayerRequest;
use JesseMaxwell\PrayerBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FrontendController extends Controller
{
    /**
     * @Route("/request/add/", name="_add_request")
     * @Method("PUT")
     * @ParamConverter("username", class="JesseMaxwellPrayerBundle:User", options={"mapping": {"username": "username"}})
     */
    public function addPrayerRequestAction(User $username)
    {
        $request       = $this->get('request');
        $prayerRequest = new PrayerRequest();
        $responseMessage = $this->container->get('prayer.responses');

        $prayerRequest
            ->setTitle($request->get('title'))
            ->setDate(new \DateTime($request->get('date')))
            ->setDescription($request->get('description'))
            ->setAnswered($request->get('answered'))
            ->setUserId($username->getId());

        $errors = $this->get('validator')->validate($prayerRequest);

        if (count($errors) > 0) {
            return new JsonResponse($responseMessage->errorMessage(
                'The information that you entered is invalid.',
                $errors
            ));
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($prayerRequest);
        $em->flush();

        return new JsonResponse(
            $responseMessage->successMessage(
                $prayerRequest->getId(),
                "Successfully added request."
            )
        );
    }

    /**
     * @Route("/request/update/{id}", name="_update_request")
     * @Method("PUT")
     * @ParamConverter("user", class="JesseMaxwellPrayerBundle:User", options={"mapping": {"username": "username"}})
     */
    public function updatePrayerRequestAction(User $user, $id)
    {
        $this->container->get('prayer.verify_action')->verifyUserPrayerRequestRelationship($user, $id);

        $this->container->get('model.persistence_handler')->update($this->get('request')->request, $id);

        return new JsonResponse(
            $this->container
                ->get('prayer.responses')
                ->successMessage("Successfully updated request")
        );
    }

    /**
     * @Route("/request/delete/{id}", name="_delete_request")
     * @Method("DELETE")
     * @ParamConverter("user", class="JesseMaxwellPrayerBundle:User", options={"mapping": {"username": "username"}})
     */
    public function deletePrayerRequestAction(User $user, $id)
    {
        $this->container->get('prayer.verify_action')->verifyUserPrayerRequestRelationship($user, $id);

        $this->container->get('model.persistence_handler')->remove($id);

        return new JsonResponse(
            $this->container
                ->get('prayer.responses')
                ->successMessage($id, 'Successfully removed the request.')
        );
    }

    /**
     * @Route("/get/request/all", name="_get_all_requests")
     * @Method("GET")
     * @ParamConverter("user", class="JesseMaxwellPrayerBundle:User", options={"mapping": {"username": "username"}})
     */
    public function getAllRequestsAction(User $user)
    {

    }

    /**
     * @Route("/get/request/{id}", name="_get_request", requirements={"id" = "\d+"})
     * @Method("GET")
     * @ParamConverter("user", class="JesseMaxwellPrayerBundle:User", options={"mapping": {"username": "username"}})
     */
    public function getRequestAction(User $user)
    {

    }
}