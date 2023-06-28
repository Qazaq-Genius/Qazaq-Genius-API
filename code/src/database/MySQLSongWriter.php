<?php

namespace QazaqGenius\LyricsApi;

use PDO;
use QazaqGenius\Transliterator;
use Slim\Exception\HttpNotImplementedException;

class MySQLSongWriter
{
    public function __construct(
        private PDO $mySqlConnection
    ) {
    }

    public function insertMedia($media, $songId): array
    {
        if ($media === null) {
            return [];
        }

        $mediumIds = [];

        foreach ($media as $name => $url) {
            $sql = $this->mySqlConnection->prepare('
                INSERT INTO Media (name, url, song_id)
                VALUES (:name, :url, :song_id)
            ');

            $sql->bindValue(":name",    $name);
            $sql->bindValue(":url",     $url);
            $sql->bindValue(":song_id", $songId);

            $sql->execute();
            $mediumIds[] = (int) $this->mySqlConnection->lastInsertId();
        }

        return $mediumIds;
    }

    public function insertAlbumToArtist(array $artistIds = null, int $albumId = null): bool
    {
        if ($albumId === null) {
            return false;
        }

        foreach ($artistIds as $artistId) {
            $sql = $this->mySqlConnection->prepare('
                INSERT INTO AlbumArtists (album_id, artist_id)
                VALUES (:album_id, :artist_id)
            ');

            $sql->bindValue(":album_id", $albumId);
            $sql->bindValue(":artist_id", $artistId);

           $sql->execute();
        }
        return true;
    }

    public function insertSongToArtist(array $artistIds, int $songId)
    {
        foreach ($artistIds as $artistId) {
            $sql = $this->mySqlConnection->prepare('
                INSERT INTO SongArtists (artist_id, song_id)
                VALUES (:artist_id, :song_id)
            ');

            $sql->bindValue(":artist_id", $artistId);
            $sql->bindValue(":song_id", $songId);

            $sql->execute();
        }
    }

    public function insertLyrics(array $lyrics, int $songId): array
    {
        $linesId = [];
        foreach ($lyrics as $verse_nr => $verse)
        {

            foreach ($verse as $line) {
                $sql = $this->mySqlConnection->prepare('
                    INSERT INTO Lyrics (verse_nr, line_nr, qazaq_cyr, qazaq_lat, english, russian, original_lang, song_id)
                    VALUES (:verse_nr, :line_nr, :qazaq_cyr, :qazaq_lat, :english, :russian, :original_lang, :song_id)
                ');

                $sql->bindValue(":verse_nr", $verse_nr);
                $sql->bindValue(":line_nr", $line["line_nr"]);
                $sql->bindValue(":qazaq_cyr", $line["qazaq_cyr"]);
                $sql->bindValue(":qazaq_lat", Transliterator::toLatin($line["qazaq_cyr"]));
                $sql->bindValue(":english", $line["english"]);
                $sql->bindValue(":russian", $line["russian"]);
                $sql->bindValue(":original_lang", $line["original_lang"]);
                $sql->bindValue(":song_id", $songId);

                $sql->execute();
                $linesId[] = (int) $this->mySqlConnection->lastInsertId();
            }
        }
        return $linesId;
    }

    public function insertSong(array $song): int
    {
        $sql = $this->mySqlConnection->prepare('
            INSERT INTO Song (title_cyr, title_lat, release_date, cover_art)
            VALUES (:title_cyr, :title_lat, :release_date, :cover_art)
        ');

        $sql->bindValue(":title_cyr",     $song["title_cyr"]);
        $sql->bindValue(":title_lat",     $song["title_lat"]);
        $sql->bindValue(":release_date", $song["release_date"]);
        $sql->bindValue(":cover_art",    $song["cover_art"]);

        $sql->execute();
        $songId = (int) $this->mySqlConnection->lastInsertId();

        return $songId;
    }

    public function insertAlbum(array $album, array $artistIds): ?int
    {
        if (isset($album['id'])) {
            $albumId = (int)$album['id'];
        } else if (isset($album['name_cyr']) || isset($album['name_lat'])) {

            /*$albumId = $this->getAlbumIdIfExist($album, $artistIds);*/

            $sql = $this->mySqlConnection->prepare('
                INSERT INTO Album (name_cyr, name_lat)
                VALUES (:name_cyr, :name_lat)
            ');

            $name_lat = $album["name_lat"] ?? Transliterator::toLatin($album["name_cyr"]);
            $sql->bindValue(":name_lat", $name_lat);
            $sql->bindValue(":name_cyr", $album["name_cyr"]);
            $sql->execute();
            $albumId = (int)$this->mySqlConnection->lastInsertId();
        } else {
            $albumId = null;
        }

        return $albumId;
    }
    /*
    private function getAlbumIdIfExist(array $album, array $artistIds): ?int
    {
        $sql = $this->mySqlConnection->prepare('
            SELECT Album.id
              FROM Artist 
              INNER JOIN AlbumArtists
                      ON Artist.id = AlbumArtists.artist_id
              INNER JOIN Album
                      ON Artist.id = Album.main_artist_id
            WHERE (Artist.id IN (:artist_id) AND Album.name_cyr = :album_name_cyr)
               OR (Artist.id IN (:artist_id) AND Album.name_lat = :album_name_lat)
        ');

        $album_name_lat = $album["name_lat"] ?? Transliterator::toLatin($album["name_cyr"]);

        $sql->bindValue(":artist_id", $artistIds);
        $sql->bindValue(":album_name_cyr", $album["name_cyr"]);
        $sql->bindValue(":album_name_lat", $album_name_lat);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        var_dump($result);
        die();
        return $result[0]["id"] ?? null;
    }*/


    public function insertArtists(array $artists): array
    {
        $artistIds = [];
        foreach ($artists as $artist) {
            $artistIds[] = $this->insertArtistAndGetID($artist);
        }
        return $artistIds;
    }

    private function insertArtistAndGetID(array $artist): int
    {
        if (!isset($artist['id'])) {
            $artistId = $this->getArtistIdIfExist($artist);
            if(!$artistId) {
                $sql = $this->mySqlConnection->prepare('
                    INSERT INTO Artist (name_cyr, name_lat)
                    VALUES (:name_cyr, :name_lat)
                ');

                $sql->bindValue(":name_lat", $artist["name_lat"]);
                $sql->bindValue(":name_cyr", $artist["name_cyr"]);
                $sql->execute();
                $artistId = (int) $this->mySqlConnection->lastInsertId();
            }
        } else {
            $artistId = (int) $artist['id'];
        }
        return $artistId;
    }

    private function getArtistIdIfExist(array $artist): ?int
    {
        $sql = $this->mySqlConnection->prepare('
            SELECT id
              FROM Artist 
            WHERE Artist.name_cyr = :name_cyr OR Artist.name_lat = :name_lat
        ');

        $sql->bindValue(":name_cyr", $artist["name_cyr"]);
        $sql->bindValue(":name_lat", $artist["name_lat"]);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result[0]["id"] ?? null;
    }

}