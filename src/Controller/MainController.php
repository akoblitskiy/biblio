<?php
namespace Src\Controller;
use Core\Request;
use Core\Controller;

class MainController extends Controller {

    public function index(Request $request) {
        return $this->view->render(['message' => 'Welcome to the Biblio library!']);
    }
}