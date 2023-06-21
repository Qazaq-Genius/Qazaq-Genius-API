<?php

namespace QazaqGenius\LyricsApi;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SongWriter
{
    public function __construct(
    ) {
    }

    /**
     * @throws JsonException
     */
    public function handle(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody(), true);
        if ($data == null){
            return ApiResponse::errorMissingData($response);
        }

        return ApiResponse::errorMissingData($response, $data);
    }
}
