<?php
namespace Src\Widget;

abstract class Widget {
    abstract public function setup($data);
    abstract public function render();
}