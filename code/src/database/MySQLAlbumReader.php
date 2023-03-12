<?php

namespace QazaqGenius\LyricsApi;

use PDO;

class MySQLAlbumReader
{
    public function __construct(
        private PDO $mySqlConnection
    ) {
    }

    public function getAlbum(int|null $albumId): array
    {
        if ($albumId === null) {
            return [];
        }

        $sql = $this->mySqlConnection->prepare('
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
