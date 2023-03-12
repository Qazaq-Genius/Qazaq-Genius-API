<?php

namespace QazaqGenius\LyricsApi;

use PDO;

class MySQLSongReader
{
    public function __construct(
        private PDO $mySqlConnection
    ) {
    }

    public function getSongById(int $id): array
    {
        $sql = $this->mySqlConnection->prepare('
            SELECT *
             FROM Song 
            WHERE id = :id
        ');

        $sql->bindValue(":id", $id);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}
