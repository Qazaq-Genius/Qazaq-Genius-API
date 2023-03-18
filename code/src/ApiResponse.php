<?php

namespace QazaqGenius\LyricsApi;

use Slim\Psr7\Response;

class ApiResponse
{
    public function sucessful(Response $response, array $responseData, int $statusCode = 200): Response
    {
        $response->getBody()->write(
            json_encode(
                $responseData,
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            )
        );
        return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
    }

    public function noData(): Response
    {
        $response = new Response();
        return $response->withStatus(204)->withHeader('Content-Type', 'application/json');
    }

    public function badData(Response $response): Response
    {
        $response->getBody()->write(
            json_encode(
                [
                    "code" => "ERROR_MISSING_DATA",
                    "message" => "Some data is missing in th JSON data"
                ],
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            )
        );

        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
}
