<?php

namespace QazaqGenius\LyricsApi;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteCollectorProxy as Group;
use Slim\App;

return static function (App $app, Factory $factory): void {

    $app->get('/', function (Request $request, Response $response) use ($factory) {
        $response->getBody()->write("Ok");
        return $response->withStatus(200);
    })->setName('healtcheck');

    $app->group('/api/v1', function (Group $v1) use ($factory) {

        $v1->group('/songs', function (Group $songs) use ($factory) {
            $songs->get('', function (Request $request, Response $response) use ($factory) {
                return $factory->createSongFinder()->handle($request, $response);
            })->setName('v1.POST.song');

            $songs->get('/id', function (Request $request, Response $response) use ($factory) {
                return $factory->createSongIdReader()->handle($request, $response);
            })->setName('v1.GET.song');

        });

        $v1->group('/song', function (Group $song) use ($factory) {
            $song->post('', function (Request $request, Response $response) use ($factory) {
                return $factory->createSongWriter()->handle($request, $response);
            })->setName('v1.POST.song');
            $song->get('/{song_id:\d+}', function (Request $request, Response $response) use ($factory) {
                return $factory->createSongReader()->handle($request, $response);
            })->setName('v1.GET.song');
        });

        //TODO: Implement
        $v1->group('/artist', function (Group $song) use ($factory) {
            $song->get('/{artist_id:\d+}', function (Request $request, Response $response) use ($factory) {
                return $factory->createArtistHandler()->handle($request, $response);
            })->setName('v1.GET.artist');
        });

        //TODO: Implement
        $v1->group('/album', function (Group $song) use ($factory) {
            $song->get('/{artist_id:\d+}', function (Request $request, Response $response) use ($factory) {
                return $response;
            })->setName('v1.GET.artist');
        });
    })->addMiddleware($factory->createAuthMiddleware());
};
