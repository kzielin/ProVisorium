<?php

namespace Controller;


use Service\Login;
use Service\RouterAbstract;

class Logowanie extends RouterAbstract
{
   function __construct($controller) { return parent::__construct($controller); }
   static $listaRol = array(
         R_ALL => 'niezalogowany',
         R_USER => 'użytkownik',
         R_MASTER => 'konsultant',
         R_ADMIN => 'administrator',
      );

   function index() {
      $this->controller->redirect();
   }
      
   function zalogujDo() {
      $isLogged = $this->login->login($_POST['login'], $_POST['pass']);
      if ($isLogged) {
         $this->controller->redirect();
      }
   }
   
   function zaloguj() {
   }
   
   function wyloguj() {
      $this->login->logout();
      $this->controller->redirect();
   }
   function listaUzytkownikowDo() {
      $v = $this->view;
      switch ($_POST['act'])
      {
         case 'add' : 
            if (Login::add($_POST['newName'], $_POST['newPasswd'], (int)$_POST['newRole']))
               $v->message = 'dodano użytkownika';
            else
               $v->warning = 'nie udało się dodać użytkownika';
            break;
         case 'del' : 
            if (Login::del($_POST['login']))
               $v->message = 'usunięto użytkownika';
            else 
               $v->warning = 'nie udało się usunąć użytkownika';
            break;
      }
   }
   
   function listaUzytkownikow() {
      $v = $this->view;
      $v->listaUzytkownikow = Login::lista();   
      $v->listaRol = self::$listaRol;
      $this->controller->setTemplate('uzytkownicy');
   }
   
   function zmianaHaslaDo() {
      $v = $this->view;
      
      $dlaLoginu = $this->login->getLogin();
      if (!empty($_POST['dlaLoginu'])&&$this->login->getRole() >= R_ADMIN)
         $dlaLoginu = $_POST['dlaLoginu'];

      if ($_POST['newpass'] == $_POST['newpass2'] && $this->login->chgPass($dlaLoginu,$_POST['oldpass'], $_POST['newpass']))
         $v->message = 'hasło zostało zmienione';
      else  
         $v->warning = 'nie udało się zmienić hasła';
   }
   function zmianaHasla() {
      $this->controller->setTemplate('zmianaHasla');
      
      $dlaLoginu = $this->args->get(2);
      
      if (!empty($dlaLoginu)&&$this->login->getRole() >= R_ADMIN)
         $this->view->dlaLoginu = $this->args->get(2);
      
   }
   
   function uprawnieniaDo(){
      $dlaLoginu = $this->args->get(2);
      if (empty($dlaLoginu)||$this->login->getRole() < R_ADMIN)
         $this->controller->redirect('logowanie/listaUzytkownikow');
         
      if (is_array($_POST['pokazy']))
      {
         Login::setProjects($dlaLoginu, $_POST['pokazy']);
         $this->view->message = 'Zapisano zmiany';
      }
   }
   
   function uprawnienia() {
      $dlaLoginu = $this->args->get(2);
      if (empty($dlaLoginu))
         $this->controller->redirect('logowanie/listaUzytkownikow');

      $this->controller->setTemplate('uprawnienia');
      $v = $this->view;
      $v->dlaLoginu = $dlaLoginu;
      $v->pokazy = Projekt::lista();

      $zaznaczone = array();
      foreach(Login::projekty($dlaLoginu) as $item)
         $zaznaczone[$item['project']] = true;
      $v->zaznaczone = $zaznaczone;

      
   }
}


