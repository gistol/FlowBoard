<?php
/**
 * Created by PhpStorm.
 * User: jeroenfrenken
 * Date: 22/11/2018
 * Time: 15:59
 */

namespace App\Responses;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponses
{

    static function badRequest(String $property, String $message) {

        $out = [
            'ok' => false
        ];

        $out['data'] = [
            'property' => $property,
            'message' => $message
        ];

        return new JsonResponse($out, Response::HTTP_BAD_REQUEST);

    }

    static function okResponse($data = [], $message = '') {

        $out = [
            'ok' => true
        ];

        if ($message !== '') {
            $out['message'] = $message;
        }

        if (!empty($data)) {
            $out['data'] = $data;
        }

        return new JsonResponse($out, Response::HTTP_OK);

    }

    static function notAuthorized() {

        return new JsonResponse([
            'ok' => false,
            'message' => 'not authorized'
        ], Response::HTTP_UNAUTHORIZED);

    }

    static function forbidden() {

        return new JsonResponse([
            'ok' => false,
            'message' => 'not allowed'
        ], Response::HTTP_FORBIDDEN);

    }

}