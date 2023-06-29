<?php

namespace QazaqGenius\LyricsApi;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;



class AuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $authHeader = $request->getHeader("Authorization");

        if (empty($authHeader)) {
            return ApiResponse::errorMissingAuth();
        }

        $authParts = explode(" ", $authHeader[0]);

        if (!isset($authParts[1]) || $authParts[0] !== "Bearer") {
            return ApiResponse::errorMissingAuthBearer();
        }

        $jwt = $authParts[1];

        //TODO: Check if JWT is valid
        if ($jwt !== ENV['API_JWT'])
        {
            return ApiResponse::errorNotAuthorized();
        }

        $response = $handler->handle($request);

        return $response;
    }
}