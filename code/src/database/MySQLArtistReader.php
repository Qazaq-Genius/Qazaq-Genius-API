<?php

namespace QazaqGenius\LyricsApi;

use PDO;

class MySQLArtistReader
{
    public function __construct(
        private PDO $mySqlConnection
    ) {
    }

    public function getArtistById(int $id): array
    {
        $sql = $this->mySqlConnection->prepare('
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
        $sql = $this->mySqlConnection->prepare('
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
}
