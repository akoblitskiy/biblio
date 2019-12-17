<?php
namespace Src\Controller;
use Core\Request;
use Core\Controller;
use Src\Model\Book;

class BookController extends Controller {

    public function show(Request $request) {
        $urlParams = $request->getParams();

        $books = Book::findBy(array_keys($urlParams), array_values($urlParams), $urlParams['_page']);
        if ($books['error']) {
            return $this->view->render($books);
        }
        $jsonData = array_map(function ($book) {
            return $book->toJson();
        }, $books);

        return $this->view->render($jsonData);
    }

    public function create(Request $request) {

        $jsonData = $request->post;
        $book = new Book();
        $book->fromJson($jsonData);
        $result = $book->insert();
        if ($result['error']) {
            return $this->view->render($result);
        }
        $book->insertRelations();
        if ($result !== false) {
            $this->response->setHeader('Location: /book/' . $result);
            $this->response->setHeader('HTTP/1.1 204 No Content');
            $this->response->setHeader("Status: 204 No Content");
        }
        return '';
    }
    public function update(Request $request) {
        $jsonData = $request->post;
        $book = new Book();
        $book->fromJson($jsonData);
        $result = $book->update();
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
        $book = new Book();
        $book->fromJson($jsonData);
        $result = $book->delete();
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