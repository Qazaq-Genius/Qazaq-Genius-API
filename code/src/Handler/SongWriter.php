<?php

namespace QazaqGenius\LyricsApi;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SongWriter
{
    public function __construct(
        private MySQLSongWriter $mySQLSongWriter
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

        $artistIds  = $this->mySQLSongWriter->insertArtists($data["artists"]);
        $albumId    = $this->mySQLSongWriter->insertAlbum($data["album"]);
        $songId     = $this->mySQLSongWriter->insertSong($data);
        $lyricsIds  = $this->mySQLSongWriter->insertLyrics($data["lyrics"], $songId);
        $this->mySQLSongWriter->insertSongToArtist($artistIds, $songId);

        $responseData = [
            "song_id" => $songId,
            "album_id" => $albumId,
            "lyrics_id" => $lyricsIds,
            "artists_id" => $artistIds,
            "created_by" => "tolik518",
            "created" => "2023-06-21 00:00:00"
        ];

        return ApiResponse::sucessful($response, $responseData, 201);

        //return ApiResponse::errorMissingData($response, $data);
    }
}
