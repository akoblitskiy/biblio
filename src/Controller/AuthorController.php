<?php
namespace Src\Controller;
use Core\Request;
use Core\Controller;
use Src\Model\Author;

class AuthorController extends Controller {

    public function show(Request $request) {
        $urlParams = $request->getParams();
        $authors = Author::findBy(array_keys($urlParams), array_values($urlParams), $urlParams['_page']);
        if ($authors['error']) {
            return $this->view->render($authors);
        }
        $jsonData = array_map(function ($author) {
            return $author->toJson();
        }, $authors);
        return $this->view->render($jsonData);
    }

    public function create(Request $request) {

        $jsonData = $request->post;
        $author = new Author();
        $author->fromJson($jsonData);
        $result = $author->insert();
        if ($result['error']) {
            return $this->view->render($result);
        }
        $author->insertRelations();
        if ($result !== false) {
            $this->response->setHeader('Location: /book/' . $result);
            $this->response->setHeader('HTTP/1.1 204 No Content');
            $this->response->setHeader("Status: 204 No Content");
        }
        return '';
    }
    public function update(Request $request) {
        $jsonData = $request->post;
        $author = new Author();
        $author->fromJson($jsonData);
        $result = $author->update();
        if ($result['error']) {
            return $this->view->render($result);
        }
        if ($result !== false) {
            $this->response->setHeader('HTTP/1.1 204 No Content');
            $this->response->setHeader("Status: 204 No Content");
        }
        return '';
    }

    public function delete(Request $request) {
        $jsonData = $request->getParams();
        $author = new Author();
        $author->fromJson($jsonData);
        $result = $author->delete();
        if ($result['error']) {
            return $this->view->render($result);
        }
        if ($result !== false) {
            $this->response->setHeader('HTTP/1.1 204 No Content');
            $this->response->setHeader("Status: 204 No Content");
        }
        return '';
    }
}