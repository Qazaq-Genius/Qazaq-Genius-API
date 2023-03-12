<?php

namespace Qazaq_Genius\Lyrics_Api;

use PDO;

class MySQLArtistReader
{
    public function __construct(
        private PDO $mySQLConnection
    ){}

    public function getArtistById(int $id): array
    {
        $sql = $this->mySQLConnection->prepare('
            SELECT *
             FROM Artist 
            WHERE id = :id
        ');

        $sql->bindValue(":id", $id);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getArtistBySongId(int $songId): array
    {
        $sql = $this->mySQLConnection->prepare('
            SELECT *
              FROM Artist 
             INNER JOIN SongArtists
                     ON Artist.id = SongArtists.artist_id
            WHERE SongArtists.song_id = :song_id
        ');

        $sql->bindValue(":song_id", $songId);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getAlbum(int|null $albumId): array
    {
        if ($albumId === null){
            return [];
        }

        $sql = $this->mySQLConnection->prepare('
            SELECT *
              FROM Album 
            WHERE Album.id = :album_id
        ');

        $sql->bindValue(":album_id", $albumId);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}