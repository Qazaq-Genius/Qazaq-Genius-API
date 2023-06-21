<?php

namespace QazaqGenius\LyricsApi;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SongReader
{
    public function __construct(
        private MySQLSongReader $mySqlSongReader,
        private MySQLArtistReader $mySqlArtistReader,
        private MySQLAlbumReader $mySqlAlbumReader,
        private MySQLLyricsReader $mySqlLyricsReader,
        private MySQLWordReader $mySqlWordReader,
        private MySQLMediaReader $mySqlMediaReader,
        private SongDataMapper $songDataMapper
    ) {
    }

    /**
     * @throws JsonException
     */
    public function handle(Request $request, Response $response): Response
    {
        $song_id = $request->getAttribute('song_id');
        if ($song_id == 0) {
            return ApiResponse::noData();
        }

        $songData = $this->mySqlSongReader->getSongById($song_id);

        if ($songData === []) {
            return ApiResponse::noData();
        }

        $artistData = $this->mySqlArtistReader->getArtistBySongId($song_id);
        $albumData  = $this->mySqlAlbumReader->getAlbum($songData['album_id']);
        $lyricsData = $this->mySqlLyricsReader->getLyricsBySongId($song_id);
        $wordData   = $this->getWordsFromLyrics($lyricsData);
        $mediaData  = $this->mySqlMediaReader->getMediaBySongId($song_id);

        $result = $this->songDataMapper->mapToSong(
            $songData,
            $artistData,
            $albumData,
            $lyricsData,
            $wordData,
            $mediaData
        );

        return ApiResponse::sucessful($response, $result);
    }

    private function getWordsFromLyrics(array $lyricsData): array
    {
        $wordData = [];

        foreach ($lyricsData as $lyrics) {
            $wordData[] = $this->mySqlWordReader->getWordsByLyricsId($lyrics['id']);
        }
        return $wordData;
    }
}
