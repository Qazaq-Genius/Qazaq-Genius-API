<?php

namespace QazaqGenius\LyricsApi;

class Factory
{
    public function __construct(
        private MySQLConnector $mySqlConnector
    ) {
    }

    public function createAuthMiddleware(): AuthMiddleware
    {
        return new AuthMiddleware();
    }

    public function createSongIdReader(): SongIdReader
    {
        return new SongIdReader(
            new MySQLSongReader(
                $this->mySqlConnector->getConnection()
            )
        );
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
            new MySQLMediaReader(
                $this->mySqlConnector->getConnection()
            ),
            new SongDataMapper()
        );
    }
    public function createSongWriter(): SongWriter
    {
        return new SongWriter(
            new MySQLSongWriter(
                $this->mySqlConnector->getConnection()
            )
        );
    }

    public function createArtistHandler(): ArtistHandler
    {
        return new ArtistHandler(
            new MySQLArtistReader(
                $this->mySqlConnector->getConnection()
            )
        );
    }
}
