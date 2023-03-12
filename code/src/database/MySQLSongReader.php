<?php

namespace Qazaq_Genius\Lyrics_Api;

class MySQLSongReader
{
    public function __construct(
        private \PDO $mySQLConnection
    ){}

    public function getSongById(int $id): array
    {
        $sql = $this->mySQLConnection->prepare('
            SELECT *
             FROM Song 
            WHERE id = :id'
        );

        $sql->bindValue(":id", $id);
        $sql->execute();
        $result = $sql->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
}