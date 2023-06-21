<?php

namespace QazaqGenius\LyricsApi;

use PDO;

class MySQLMediaReader
{
    public function __construct(
        private PDO $mySqlConnection
    ) {
    }

    public function getMediaBySongId(int $songId):  array | false
    {
        $sql = $this->mySqlConnection->prepare('
            SELECT *
              FROM Media 
             WHERE Media.song_id = :song_id
        ');

        $sql->bindValue(":song_id", $songId);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
