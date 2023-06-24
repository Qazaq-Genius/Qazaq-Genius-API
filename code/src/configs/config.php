<?php

define("DB_HOST", ENV['MYSQL_HOST']);
define("DB_NAME", ENV['MYSQL_DB']);
define("DB_PORT", '3306');
define("DB_USER", ENV['MYSQL_USER']);
define("DB_PASS", ENV['MYSQL_ROOT_PASSWORD']);
define("DB_OPT", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);


const DB_DSN = 'mysql:host=' . DB_HOST . ';' .
    'port='      . DB_PORT . ';' .
    'dbname='    . DB_NAME;
