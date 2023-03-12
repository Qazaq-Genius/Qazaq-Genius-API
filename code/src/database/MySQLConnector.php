<?php
namespace Qazaq_Genius\Lyrics_Api;

use Exception;
use PDO;
use RuntimeException;

class MySQLConnector
{
    private PDO $connection;

    public function __construct()
    {
        require_once (CONFIGS . "config.php");
        try {
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, DB_OPT);
            $this->connection = $pdo;
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}