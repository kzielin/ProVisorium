<?php

namespace Controller;

use Service\RouterAbstract;
use Service\Themes;

class Motywy extends RouterAbstract
{
   function __construct($controller) { return parent::__construct($controller); }
   function index() {
      $this->controller->redirect('motywy/lista');
   }
   
   function listaDo() {
      $v = $this->view;
      if ($this->login->getRole() >= R_USER) {
         
         if ($_POST['act']=='ren' && !empty($_POST['newName']) && Themes::validId($_POST['id'])) {
            $v->messageWarning(Themes::rename($_POST['id'], $_POST['newName']), 'Zapisano zmiany', 'Nie udało się zapisać zmian');
         }
         
         if ($_POST['act']=='add' && !empty($_POST['name'])) {
            $v->messageWarning( Themes::add($_POST['name'], $_POST['width'], $_POST['height'])
                , 'Dodano pokaz', 'Nie udało się dodać motywu');
         }
         
         if ($_POST['act']=='del' && Themes::validId($_POST['id'])) {
            $v->messageWarning(Themes::del($_POST['id']), 'Usunięto pokaz', 'Nie udało się usunąć motywu');
         }
      }
   }
   
   function lista() {
      $this->view->assign('lista', Themes::all());
      $this->controller->setTemplate('motywy_lista');
   }

}
