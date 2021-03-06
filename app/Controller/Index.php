<?php

namespace Controller;

use Service\RouterAbstract;

class Index extends RouterAbstract
{
   function __construct($controller) { return parent::__construct($controller); }
   function index() {
      if ($this->login->logged())
         $this->controller->redirect('pokaz');
      else
         $this->controller->redirect('logowanie/zaloguj');
   }
}
