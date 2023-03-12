<?php

namespace Qazaq_Genius\Lyrics_Api;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArtistHandler
{
    public function __construct(
        private MySQLArtistReader $mySQLArtistReader,
        private ApiResponse $apiResponse
    ) {
    }

    /**
     * @throws JsonException
     */
    public function handle(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $song_id = $request->getAttribute('artist_id');

        $songData = $this->mySQLArtistReader->getArtistById($song_id);

        if (empty($songData)) {
            return $this->apiResponse->noData();
        }

        return $this->apiResponse->sucessful($response, $songData);
    }
}
