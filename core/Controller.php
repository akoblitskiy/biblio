<?php
namespace Core;

abstract class Controller {
    /** @var Response */
    protected $response;

    /** @var App */
    protected $app;

    /** @var View */
    protected $view;

    public function setApp($app) {
        $this->app = $app;
        $this->response = $app->response;
        $this->view = new View($app->params['view']);
    }

    public function handle($request, $actionName, $urlSuffix) {

        ob_start();
        $this->preAction();
        $this->$actionName($request, $urlSuffix ? : []);
        $this->postAction();
        $output = ob_get_contents();
        ob_end_clean();

        $this->response->setContent($output);
    }

    public function redirect($url) {
        Response::redirect($url);
        throw new StopException();
    }

    protected function preAction() { }

    protected function postAction() { }
}