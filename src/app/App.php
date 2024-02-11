<?php

namespace App;

use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;

use App\Config;
use App\Router;

class App
{
    private readonly Router $router;

    private const PATH_CONFIG = 'config/';
    private const PATH_ROUTES = 'routes/';

    public function __construct(string $pathToApp)
    {
        $this->initConfig($pathToApp);
        $this->router = $this->initRouter($pathToApp);
    }

    private function initConfig(string $pathToApp)
    {
        Config::init($pathToApp . self::PATH_CONFIG);
    }

    private function initRouter(string $pathToApp): Router
    {
        $routesFile = Config::get('router.routes.web');
        return new Router($pathToApp . self::PATH_ROUTES . $routesFile);
    }

    public function run()
    {
        $request = Request::createFromGlobals();
        $routeInfo = $this->router->dispatch($request);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // TODO: Implement this
                die('Not found');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // TODO: Implement this
                die('Method not allowed');
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $params = $routeInfo[2];

                $object = new $handler[0];
                $method = $handler[1];
                $response = $object->$method($request->toArray());
                
                break;
        }

        $response->send();
    }
}