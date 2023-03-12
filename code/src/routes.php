<?php
namespace Qazaq_Genius\Lyrics_Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteCollectorProxy as Group;
use Slim\App;

return static function (App $app, Factory $factory): void {

    $app->group('/api/v1', function (Group $v1) use ($factory) {
        $v1->group('/song', function (Group $song) use ($factory) {
            $song->get('/{song_id:\d+}', function (Request $request, Response $response) use ($factory) {
                return $factory->createSongHandler()->handle($request, $response);
            })->setName('v1.GET.song');
        });
    });
};