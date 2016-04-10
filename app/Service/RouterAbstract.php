<?php

namespace Service;

abstract class RouterAbstract
{

    var $args;
    var $login;

    /** @var Controller */
    var $controller;

    /** @var Renderer $view */
    var $view;
    
    public function __construct(Controller $controller)
    {
        $this->args = new Args();
        $this->login = Login::getInstance();
        $this->controller = $controller;
        $this->view = $controller->view;
    }
   
    abstract public function index();
}