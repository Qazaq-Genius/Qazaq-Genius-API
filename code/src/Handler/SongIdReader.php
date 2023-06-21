<?php

namespace QazaqGenius\LyricsApi;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SongIdReader
{
    public function __construct(
        private MySQLSongReader $mySqlSongReader
    ) {
    }

    /**
     * @throws JsonException
     */
    public function handle(Request $request, Response $response): Response
    {
        return ApiResponse::sucessful(
            $response,
            $this->mySqlSongReader->getAllSongIDs()
        );
    }
}