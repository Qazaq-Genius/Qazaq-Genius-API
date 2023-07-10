<?php

namespace QazaqGenius\LyricsApi;

use Slim\Psr7\Response;

class ApiResponse
{
    public static function sucessful(Response $response, array $responseData = [], int $statusCode = 200): Response
    {
        $response->getBody()->write(
            json_encode(
                $responseData,
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            )
        );
        return $response->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*');
    }

    public static function noData(): Response
    {
        $response = new Response();
        return $response->withStatus(204)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*');
    }

    public static function errorNotAuthorized(): Response
    {
        $response = new Response();

        $response->getBody()->write(
            json_encode(
                [
                    "code" => "ERROR_NOT_AUTHORIZED",
                    "message" => "You're not authorized to access that ressource"
                ],
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            )
        );

        return $response->withStatus(403)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*');
    }

    public static function errorMissingAuthBearer(): Response
    {
        $response = new Response();

        $response->getBody()->write(
            json_encode(
                [
                    "code" => "ERROR_MISSING_AUTH",
                    "message" => "Authorization Bearer is missing from header or is malformed"
                ],
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            )
        );

        return $response->withStatus(401)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*');
    }

    public static function errorMissingAuth(): Response
    {
        $response = new Response();

        $response->getBody()->write(
            json_encode(
                [
                    "code" => "ERROR_MISSING_AUTH",
                    "message" => "Authorization is missing from header"
                ],
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            )
        );

        return $response->withStatus(401)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*');
    }

    public static function errorMissingData(array $missingFields = []): Response
    {
        $response = new Response();

        if (empty($missingFields))
        {
            $response->getBody()->write(
                json_encode(
                    [
                        "code" => "ERROR_MISSING_DATA",
                        "message" => "Data is missing in the JSON body"
                    ],
                    JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
                )
            );
        } else {
            $missingFieldsString = implode(", ", $missingFields);
            $response->getBody()->write(
                json_encode(
                    [
                        "code" => "ERROR_MISSING_DATA",
                        "message" => "$missingFieldsString is missing in the JSON body"
                    ],
                    JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
                )
            );
        }

        return $response->withStatus(400)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*');
    }
}
