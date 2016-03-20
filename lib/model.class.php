<?php

abstract class Model {

   var $args;
   var $login;
   var $controller;
   var $view;
	public function __construct($controller)
	{
      $this->args = new Args();
      $this->login = Login::getInstance();
      $this->controller = $controller;
      $this->view = $controller->view;
	}
   
   abstract public function index();
}