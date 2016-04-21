<?php

namespace Controller;

use Service\JsonResponse;
use Service\Kontrolki;
use Service\Projekt;
use Service\RouterAbstract;

class Ajax extends RouterAbstract
{
   function __construct($controller) {
      $renderer = new JsonResponse();
      $controller->setRenderer($renderer);
      $controller->noRender = true;
      return parent::__construct($controller);
   }
   function __destruct()
   {
      $this->view->display();
   }

   function index() {
      $this->view->assign('message', 'niepoprawne wywołanie');
   }
   
   function propsDo() {

   }

   function props() {
      $v = $this->view;
      $id = $this->args->get(2); // id komponentu
      $komponent = Kontrolki::get($id);
      $v->komponent = $komponent;
   }


}
