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
}
