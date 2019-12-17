<?php
namespace Core;

class View {
    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function render($data) {
        if($data) {
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($data);
        }
    }

}