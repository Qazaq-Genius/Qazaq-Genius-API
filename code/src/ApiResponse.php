<?php

namespace Qazaq_Genius\Lyrics_Api;

class ApiResponse
{
    public function sucessfulResponse($response, $responseData, $statusCode = 200)
    {
        $response->getBody()->write(
            json_encode(
                $responseData,
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            )
        );
        return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
    }
}