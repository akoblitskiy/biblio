<?php
namespace Core;

class Router {
    protected $request;
    protected $controllerParams;
    protected $pathParams = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function processRoute($routes) {
        $path = trim($this->request->getRoute(), '/');
        foreach ($routes as $routeParams) {
            $pattern = trim($routeParams['path'], '/');
            if ($routeParams['method'] == $this->request->requestMethod) {
                $result = $this->processPath($path, $pattern, $this->request->requestMethod);
                if ($result !== false) {
                    if ($this->pathParams) {
                        $this->addRequestParams($this->pathParams);
                    }
                    return [$routeParams['controller'], $routeParams['action']];
                }
            }
        }
        throw new Exception404();
    }

    public function addRequestParams($params) {
        foreach ($params as $key => $value) {
            $this->request->addParam($key, $value);
        }
    }

    public function processPath($path, $pattern, $method) {
        $tokens = preg_split('/[\/]+/', $path);
        $rules = preg_split('/[\/]+/', $pattern);
        $pathParams = [];
        $varsCount = 0;
        reset($tokens);
        foreach ($rules as $rule) {
            $token = current($tokens);
            if (preg_match('/^:([^:]*)$/', $rule, $matches)) {
                $this->pathParams[$matches[1]] = $token;
                $varsCount++;
            } else if ($token != $rule) {
                return false;
            }
            next($tokens);
        }
        if (count($tokens) != count($rules) && count($tokens) != count($rules) - $varsCount) {
            return false;
        }
        return true;
    }
}