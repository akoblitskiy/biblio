<?php
namespace Core;

class Request {
    private static $instance;

    public $route;
    public $params;
    public $post;

    public static function getInstance() {
        return self::$instance;
    }

    public static function generateFromGlobals() {
        self::$instance = new self();
        self::$instance->init();
        return self::$instance;
    }

    private function __construct() {}

    public function init() {
        foreach($_SERVER as $key => $value)
        {
            $this->{Utils::toCamelCase($key)} = $value;
        }
        $this->post = $_POST;
        $this->params = $_REQUEST;
        $this->route = $this->requestUri ? : '/';
    }

    public function getRoute() {
        return $this->route;
    }

    public function getParams() {
        return $this->params;
    }

    public function getParam($name) {
        return $this->params[$name];
    }

    public function addParam($key, $value) {
        $this->params[$key] = $value;
    }
}