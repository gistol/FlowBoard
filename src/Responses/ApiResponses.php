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

}