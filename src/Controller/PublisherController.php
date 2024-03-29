<?php
namespace Src\Controller;
use Core\Request;
use Core\Controller;
use Src\Model\Publisher;

class PublisherController extends Controller {

    public function show(Request $request) {
        $urlParams = $request->getParams();
        $publishers = Publisher::findBy(array_keys($urlParams), array_values($urlParams), $urlParams['_page']);
        if ($publishers['error']) {
            return $this->view->render($publishers);
        }
        $jsonData = array_map(function ($publisher) {
            return $publisher->toJson();
        }, $publishers);
        return $this->view->render($jsonData);
    }

    public function create(Request $request) {

        $jsonData = $request->post;
        $publisher = new Publisher();
        $publisher->fromJson($jsonData);
        $result = $publisher->insert();
        $publisher->insertRelations();
        if ($result !== false) {
            $this->response->setHeader('Location: /book/' . $result);
            $this->response->setHeader('HTTP/1.1 204 No Content');
            $this->response->setHeader("Status: 204 No Content");
        }
        return '';
    }
    public function update(Request $request) {
        $jsonData = $request->post;
        $publisher = new Publisher();
        $publisher->fromJson($jsonData);
        $result = $publisher->update();
        if ($result !== false) {
            $this->response->setHeader('HTTP/1.1 204 No Content');
            $this->response->setHeader("Status: 204 No Content");
        }
        return '';
    }

    public function delete(Request $request) {
        $jsonData = $request->getParams();
        $publisher = new Publisher();
        $publisher->fromJson($jsonData);
        $result = $publisher->delete();
        if ($result !== false) {
            $this->response->setHeader('HTTP/1.1 204 No Content');
            $this->response->setHeader("Status: 204 No Content");
        }
        return '';
    }
}