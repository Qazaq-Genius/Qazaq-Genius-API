<?php

namespace Qazaq_Genius\Lyrics_Api;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SongHandler
{
    public function __construct(
        private MySQLSongReader $mySQLSongReader,
        private MySQLArtistReader $mySQLArtistReader,
        private MySQLAlbumReader $mySQLAlbumReader,
        private SongDataMapper $songDataMapper,
        private ApiResponse $apiResponse
    ) {
    }

    /**
     * @throws JsonException
     */
    public function handle(Request $request, Response $response): Response
    {
        $song_id = $request->getAttribute('song_id');

        $songData = $this->mySQLSongReader->getSongById($song_id);
        $artistData = $this->mySQLArtistReader->getArtistBySongId($song_id);
        $albumData = $this->mySQLAlbumReader->getAlbum($songData['album_id']);

        if (empty($songData) || empty($artistData)) {
            return $this->apiResponse->noData();
        }

        $result = $this->songDataMapper->mapToSong($songData, $artistData, $albumData);

        return $this->apiResponse->sucessful($response, $result);
    }
}
