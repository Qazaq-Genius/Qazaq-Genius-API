<?php
declare(strict_types=1);
namespace Qazaq_Genius\Lyrics_Api;

use Slim\Factory\AppFactory;

require_once('../src/configs/directories.php');

require_once(VENDOR . 'autoload.php');

//Programm
session_start();
$mySQLConnector = new MySQLConnector();

$app = AppFactory::create();

$factory = new Factory($mySQLConnector);
$routes = require_once(SRC . 'routes.php');
$routes($app, $factory);

$app->run();
