<?php

namespace Qazaq_Genius\Lyrics_Api;

use PDO;

class MySQLAlbumReader
{
    public function __construct(
        private PDO $mySQLConnection
    ) {
    }

    public function getAlbum(int|null $albumId): array
    {
        if ($albumId === null) {
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
