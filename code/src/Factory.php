<?php

namespace QazaqGenius\LyricsApi;

class Factory
{
    public function __construct(
        private MySQLConnector $mySqlConnector
    ) {
    }

    public function createSongReader(): SongReader
    {
        return new SongReader(
            new MySQLSongReader(
                $this->mySqlConnector->getConnection()
            ),
            new MySQLArtistReader(
                $this->mySqlConnector->getConnection()
            ),
            new MySQLAlbumReader(
                $this->mySqlConnector->getConnection()
            ),
            new MySQLLyricsReader(
                $this->mySqlConnector->getConnection()
            ),
            new MySQLWordReader(
                $this->mySqlConnector->getConnection()
            ),
            new SongDataMapper(),
            $this->createApiResponse()
        );
    }
    public function createSongWriter(): SongWriter
    {
        return new SongWriter(
            $this->createApiResponse()
        );
    }

    public function createArtistHandler(): ArtistHandler
    {
        return new ArtistHandler(
            new MySQLArtistReader(
                $this->mySqlConnector->getConnection()
            ),
            $this->createApiResponse()
        );
    }

    public function createApiResponse(): ApiResponse
    {
        return new ApiResponse();
    }
}
