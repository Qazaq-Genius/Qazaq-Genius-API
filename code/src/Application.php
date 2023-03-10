<?php
namespace Qazaq_Genius\Lyrics_Api;

use Slim\App;

class Application
{
    public function __construct(
        private Router $router
    ){}

    public function start(App $app): void
    {
        $app->addErrorMiddleware(true, true, true);
        $this->router->setRoutes($app);
    }
}