<?php
namespace Src\Controller;
use Core\Request;
use Core\Controller;

class AuthorController extends Controller {

    public function login(Request $request) {
        $this->view->setContentView('auth/login.php');
        return $this->view->render((array)$this);
    }

    public function signup(Request $request) {
        $this->view->setContentView('auth/signin.php');
        return $this->view->render((array)$this);
    }
}