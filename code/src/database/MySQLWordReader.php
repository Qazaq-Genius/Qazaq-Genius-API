<?php

namespace QazaqGenius\LyricsApi;

use PDO;

class MySQLWordReader
{
    public function __construct(
        private PDO $mySqlConnection
    ) {
    }

    public function getWordsByLyricsId(int $lyricsId): array
    {
        $sql = $this->mySqlConnection->prepare('
            SELECT *
              FROM Words 
             WHERE Words.lyrics_id = :lyrics_id
        ');

        $sql->bindValue(":lyrics_id", $lyricsId);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
