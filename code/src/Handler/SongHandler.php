<?php

namespace Qazaq_Genius\Lyrics_Api;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class SongHandler
{
    public function __construct(
        private MySQLSongReader $mySQLSongReader,
        private ApiResponse $apiResponse
    ){}

    /**
     * @throws JsonException
     */
    public function handle(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $song_id = $request->getAttribute('song_id');

        $responseData = $this->mySQLSongReader->getSongById($song_id);

        return $this->apiResponse->sucessfulResponse($response, $responseData);
    }
}