<?php

namespace QazaqGenius\LyricsApi;

use PDO;

class MySQLLyricsReader
{
    public function __construct(
        private PDO $mySqlConnection
    ) {
    }

    public function getLyricsBySongId(int $songId): array
    {
        $sql = $this->mySqlConnection->prepare('
            SELECT *
              FROM Lyrics 
             WHERE song_id = :song_id
        ');

        $sql->bindValue(":song_id", $songId);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
