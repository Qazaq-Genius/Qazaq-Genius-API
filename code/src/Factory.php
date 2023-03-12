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
            $this->createApiResponse()
        );
    }

    public function createApiResponse(): ApiResponse
    {
        return new ApiResponse();
    }
}