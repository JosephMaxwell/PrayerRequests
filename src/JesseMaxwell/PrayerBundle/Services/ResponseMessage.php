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
 * @author    Jesse Maxwell
 * @copyright Swift Otter Studios, 7/13/15
 * @package   default
 **/

namespace JesseMaxwell\PrayerBundle\Services;


class ResponseMessage
{
    /**
     * @param null   $id
     * @param string $message
     *
     * @return array
     */
    public function successMessage($id = null, $message = "Success!")
    {
        return [
            'success' => true,
            'content' => $message,
            'errors'  => false,
            'id'      => $id
        ];
    }

    /**
     * @param string $message
     * @param array  $errors
     *
     * @return array
     */
    public function errorMessage($message = "Error!", $errors)
    {
        $errorList = [];

        if (is_array($errors) || $errors instanceof \Traversable ) {
            foreach ($errors as $error) {
                $errorList[] = [
                    'property' => $error->getPropertyPath(),
                    'message'  => $error->getMessage()
                ];
            }
        }

        return [
            'success' => false,
            'content' => $message,
            'errors' => json_encode($errorList)
        ];
    }

    /**
     * Returns an failure message with no errors
     * @see $this->errorResponse()
     *
     * @param string $message
     *
     * * @return array
     */
    public function failureMessage($message = "Failed")
    {
        return [
            'success' => false,
            'content' => $message,
            'errors'  => false,
        ];
    }
}