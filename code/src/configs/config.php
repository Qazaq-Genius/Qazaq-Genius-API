<?php

define("DB_HOST", 'database');
define("DB_NAME", 'qg_song_data');
define("DB_PORT", '3306');
define("DB_USER", 'root');
define("DB_PASS", getenv('MYSQL_ROOT_PASSWORD'));

const DB_DSN = 'mysql:host=' . DB_HOST . ';' .
    'port='      . DB_PORT . ';' .
    'dbname='    . DB_NAME;