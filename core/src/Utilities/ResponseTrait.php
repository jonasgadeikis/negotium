<?php

namespace App\Utilities;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    public function createSuccessResponse($data)
    {
        return new Response(
            $data,
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
    }

    public function createNotFoundResponse()
    {
        return new JsonResponse([
            'code' => 404,
            'message' => 'Not found.',
        ], 404);
    }
}