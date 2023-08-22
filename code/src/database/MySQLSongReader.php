<?php

namespace QazaqGenius\LyricsApi;

use PDO;

class MySQLSongReader
{
    public function __construct(
        private PDO $mySqlConnection
    ) {
    }

    public function getAllSongIDs(): array
    {
        $sql = $this->mySqlConnection->prepare('
            SELECT id
              FROM Song 
        ');

        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_COLUMN);

        if (!$result) {
            return [];
        }

        return $result;
    }

    public function getSongById(int $id): array | false
    {
        $sql = $this->mySqlConnection->prepare('
            SELECT *
              FROM Song 
             WHERE id = :id
        ');

        $sql->bindValue(":id", $id);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if(!$result) {
            return [];
        }

        return $result;
    }

    public function getSongByName(string $name): array | false
    {
        $sqlSong = $this->mySqlConnection->prepare('
            SELECT Song.id, Song.id, release_date, title_cyr, title_lat, cover_art
              FROM Song
             WHERE Song.title_lat LIKE :name 
                OR Song.title_cyr LIKE :name 
             GROUP BY Song.id
             LIMIT 5
        ');

        $sqlArtist = $this->mySqlConnection->prepare('
            SELECT Song.id, Song.id, release_date, title_cyr, title_lat, cover_art
              FROM Song
              LEFT JOIN SongArtists SA on Song.id = SA.song_id
              LEFT JOIN Artist on Artist.id = SA.artist_id
             WHERE Artist.name_lat LIKE :name 
                OR Artist.name_lat LIKE :name 
             GROUP BY Song.id
             LIMIT 5
        ');

        $sqlSong->bindValue(":name", "%" . $name . "%");
        $sqlArtist->bindValue(":name", "%" . $name . "%");

        $sqlSong->execute();
        $sqlArtist->execute();

        $resultSong = $sqlSong->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_GROUP | PDO::FETCH_UNIQUE);
        $resultArtist = $sqlArtist->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_GROUP | PDO::FETCH_UNIQUE);

        return [
          "song" => $resultSong,
          "artist" => $resultArtist
        ];
    }
}
