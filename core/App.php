<?php
namespace Core;

class App {
    public $params;
    public $routes;
    public $env;
    public $response;

    public function __construct($config)
    {
        $this->params = $config['params'];
        $this->routes = $config['routes'];
        $this->env = $config['env'];
    }

    public function run($config)
    {
        $dbConfig = $this->params['services']['database_' . $this->env] ? : $this->params['services']['database'];
        DBManager::setup($dbConfig, $this->params['pagination']['count']);

        $request = Request::generateFromGlobals();
        $router = new Router($request);
        $this->response = new Response();

        try {
            list($controllerName, $actionName, $urlSuffix) = $router->processRoute($this->routes);

            $controllerNamespace = rtrim($this->params['controllers']['namespace'], '\\') . '\\';
            $controllerName = $controllerNamespace . $controllerName;
            $controller = new $controllerName();

            $controller->setApp($this);
            $controller->handle($request, $actionName, $urlSuffix);

        } catch (Exception404 $e) {
            $this->error404($request);
        } catch (StopException $e) {
            die();
        }

        $this->response->sendHeaders();
        echo $this->response->getContent();
    }

    protected function error404($request) {
        $host = 'http://'. $request->httpHost .'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
        include '404.php';
        exit(0);
    }
}