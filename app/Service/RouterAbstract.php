<?php

namespace Service;

abstract class RouterAbstract
{

    var $args;
    var $login;

    protected $requireLogin = false;

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
        if ($this->requireLogin && !$this->login->logged()) {
            $this->controller->redirect();
        }
    }
   
    abstract public function index();
}