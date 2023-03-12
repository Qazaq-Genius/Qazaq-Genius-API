<?php

namespace QazaqGenius\LyricsApi;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SongHandler
{
    public function __construct(
        private MySQLSongReader $mySqlSongReader,
        private MySQLArtistReader $mySqlArtistReader,
        private MySQLAlbumReader $mySqlAlbumReader,
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

        $songData = $this->mySqlSongReader->getSongById($song_id);
        $artistData = $this->mySqlArtistReader->getArtistBySongId($song_id);
        $albumData = $this->mySqlAlbumReader->getAlbum($songData['album_id']);

        if (empty($songData) || empty($artistData)) {
            return $this->apiResponse->noData();
        }

        $result = $this->songDataMapper->mapToSong($songData, $artistData, $albumData);

        return $this->apiResponse->sucessful($response, $result);
    }
}
