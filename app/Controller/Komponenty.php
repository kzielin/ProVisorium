<?php

namespace Controller;

use Service\Kontrolki;
use Service\RouterAbstract;
use Service\Themes;

class Komponenty extends RouterAbstract
{
   protected $requireLogin = true;
   function __construct($controller) { return parent::__construct($controller); }
   function index() {
      $this->controller->redirect('komponenty/lista');
   }
   function listaDo() {
      $v = $this->view;
      if ($_POST['act'] == 'add' && !empty($_POST['newName']))
      {
         $v->messageWarning(Kontrolki::simpleAdd($_POST['newName'], $_POST['theme']),
             'Dodano komponent','Nie udało się dodać komponentu ');
      }
      if ($_POST['act'] == 'del' && is_numeric($_POST['id']))
      {
         $v->messageWarning(Kontrolki::del($_POST['id']),
             'Usunięto komponent', 'Nie udało się usunąć komponentu ');
      }

   }
   function lista() {
      $v = $this->view;
      $v->assign('lista', Kontrolki::lista());
      $v->assign('themes', Themes::all());
   }
   
   function edytujDo() {
      $v = $this->view;
      $nr = $this->args->get(2);
      if (!Kontrolki::validId($nr))
         $this->controller->redirect('komponenty/lista');

         
      $props = array();
      if (is_array($_POST['propId']) && is_array($_POST['propType']) && is_array($_POST['propDefault'])) {
         foreach ($_POST['propId'] as $k => $item)
            if (!empty($item))
               $props[$item] = array(
                  'type' => $_POST['propType'][$k],
                  'default' => $_POST['propDefault'][$k],
               );
      }
      if (Kontrolki::save($nr, $_POST['html'], $_POST['css'], $_POST['js'], $props, $_POST['icon']))
         $v->message = 'Zapisano zmiany';
      else {
         $v->warning   = 'Nie udało się zapisać zmian';
         $v->savedHtml = $_POST['html'];
         $v->savedCss  = $_POST['css'];
         $v->savedJs   = $_POST['js'];
         $v->savedIcon = $_POST['icon'];
      }
   }
   
   function edytuj() {
      $v = $this->view;
      $nr = $this->args->get(2);
      if (!Kontrolki::validId($nr))
         $this->controller->redirect('komponenty/lista');

      $komponent = Kontrolki::get($nr);
      $v->idKomponentu = $nr;
      $this->controller->setTemplate('kontrolka_edycja');
      $v->component = $komponent;
   }
   
   function preview() {
      $v = $this->view;
      
      foreach (array('css','js','html','name') as $item) 
         $d[$item] = $_POST[$item];
      foreach (array('props') as $item)
         $d[$item] = json_decode($_POST[$item]);
      
      
      foreach (array('css','js','html','name') as $item) {
         foreach ($d['props'] as $prop ) {
            if ($prop->typ == 'e') $prop->def = array_shift(explode(';',$prop->def));
            $_POST[$item] = str_replace('#'.$prop->id, $prop->def, $_POST[$item]);
         }
         $v->$item = $_POST[$item];
      }
      
      $this->controller->setTemplate('kontrolka_podglad');
   }
   
   function eksportuj() {
      $nr = $this->args->get(2);
      if (Kontrolki::validId($nr)) {
         $this->controller->setNoRender(true);
         $komponent = Kontrolki::get($nr);
         if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
            header('Content-Type: application/force-download');
         else
            header('Content-Type: application/octet-stream');
         header('Content-disposition: attachment; filename="komponent_'.$komponent['name'].'.serialized"');
         echo serialize($komponent);
      } else {
         $this->controller->redirect();
      }
   }
   
   function file2base64() {
      if (is_uploaded_file($_FILES['image']['tmp_name'])) {
         echo '<textarea cols=70 rows=10 id=base>url(data:image/';
         echo array_pop(explode('.',$_FILES['image']['name']));
         echo ';base64,';
         echo base64_encode(file_get_contents($_FILES['image']['tmp_name']));
         echo ')</textarea>';
      }
      $v = $this->controller->setNoRender(true);
   }
}




