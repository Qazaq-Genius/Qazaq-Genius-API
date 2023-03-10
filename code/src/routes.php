<?php
namespace Qazaq_Genius\Lyrics_Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;

return function (App $app, Factory $factory): void {
    $app->group('/v1', function (RouteCollectorProxy $v1) {
        $v1->get('/song', function (Request $request, Response $response) {
            $response->getBody()->write("Moin");
            return $response;
        })->setName('v1.GET.song');
    });
};