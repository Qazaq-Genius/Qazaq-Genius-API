<?php
namespace Qazaq_Genius\Lyrics_Api;

class Factory
{
    public function __construct(
        private MySQLConnector $mySQLConnector
    ){}

    public function createSongHandler(): SongHandler
    {
        return new SongHandler(
            new MySQLSongReader(
                $this->mySQLConnector->getConnection()
            ),
            new MySQLArtistReader(
                $this->mySQLConnector->getConnection()
            ),
            new MySQLAlbumReader(
                $this->mySQLConnector->getConnection()
            ),
            new SongDataMapper(),
            $this->createApiResponse()
        );
    }

    public function createArtistHandler(): ArtistHandler
    {
        return new ArtistHandler(
            new MySQLArtistReader(
                $this->mySQLConnector->getConnection()
            ),
            $this->createApiResponse()
        );
    }

    public function createApiResponse(): ApiResponse
    {
        return new ApiResponse();
    }
}