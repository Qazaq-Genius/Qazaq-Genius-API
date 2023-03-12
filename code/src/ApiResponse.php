<?php

namespace QazaqGenius\LyricsApi;

use Slim\Psr7\Response;

class ApiResponse
{
    public function sucessful($response, $responseData, $statusCode = 200)
    {
        $response->getBody()->write(
            json_encode(
                $responseData,
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            )
        );
        return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
    }

    public function noData()
    {
        $response = new Response();
        return $response->withStatus(204)->withHeader('Content-Type', 'application/json');
    }
}
