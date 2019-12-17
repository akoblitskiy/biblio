<?php
namespace Src\Widget;

class Menu extends Widget {
    protected $data;

    public function setup($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        include __DIR__ . '/../../view/widgets/menu.php';
    }
}