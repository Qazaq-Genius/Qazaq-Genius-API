<?php
declare(strict_types=1);
namespace QazaqGenius\LyricsApi;

use Slim\Factory\AppFactory;

require_once('../src/configs/directories.php');
require_once(VENDOR . 'autoload.php');

//Load .env
if (str_contains(gethostname(), ".")) {
    $env = parse_ini_file(dirname(__DIR__, 2) . '/.env');
} else {
    $env = parse_ini_file(dirname(__DIR__, 1) . '/.env.local');
}
define("ENV", $env);

//Programm
session_start();
$mySQLConnector = new MySQLConnector();

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$factory = new Factory($mySQLConnector);
$routes = require_once(SRC . 'routes.php');
$routes($app, $factory);

$app->run();
