<?php

namespace Controller;

use Service\Ekran;
use Service\Kontrolki;
use Service\RouterAbstract;

class Pokaz extends RouterAbstract
{
   function __construct($controller) { return parent::__construct($controller); }
   function index() {
      $this->controller->redirect('pokaz/lista');
   }
   
   function listaDo() {
      $v = $this->view;
      if ($this->login->getRole() >= R_USER) {
         
         if ($_POST['act']=='ren' && !empty($_POST['newName']) && Projekt::validId($_POST['showId'])) {
            if (Projekt::zmienNazwe($_POST['showId'], $_POST['newName']))
               $v->message = 'Zapisano zmiany';
            else
               $v->warning = 'Nie udało się zapisać zmian ';
         }
         
         if ($_POST['act']=='add' && !empty($_POST['showName'])) {
            if (Projekt::dodaj($_POST['showName'])) 
               $v->message = 'Dodano pokaz';
            else
               $v->warning = 'Nie udało się dodać pokazu ';
         }
         
         if ($_POST['act']=='del' && Projekt::validId($_POST['showId'])) {
            if (Projekt::usun($_POST['showId']))
               $v->message = 'Usunięto pokaz';
            else
               $v->warning = 'Nie udało się usunąć pokazu ';
         }
      }
   }
   
   function lista() {
      $v = $this->view;
      $v->listaPokazow = Projekt::lista( $this->login->getRole() >= R_MASTER ? null : $this->login->getLogin());   
      $this->controller->setTemplate('pokaz_lista');
   }

   function edytujDo() {
      $v = $this->view;
      $projId = $this->args->get(2);
      if (!Projekt::validId($projId))
         $this->controller->redirect();
      if ($this->login->getRole() >= R_USER) {
      
         if ($_POST['act']=='add' && !empty($_POST['screenName'])) {
            if (Projekt::dodajEkran($projId,$_POST['screenName']))
               $v->message = 'Dodano ekran';
            else
               $v->warning = 'Nie udało się dodać ekranu ';
         }
         
         if ($_POST['act']=='ren' && !empty($_POST['newName'])) {
            if (Projekt::zmienNazweEkranu($projId, $_POST['screenId'], $_POST['newName']))
               $v->message = 'Zapisano zmiany';
            else
               $v->warning = 'Nie udało się zapisać zmian ';
         }
         
         if ($_POST['act']=='del') {
            if (Projekt::usunEkran($projId, $_POST['screenId']))
               $v->message = 'Usunięto ekran';
            else
               $v->warning = 'Nie udało się usunąć ekranu ';
         }
         if (!isset($_POST['act'])) {
            if (Projekt::ustawEkran($projId, $_POST['screenId']))
               $v->message = 'Zapisano zmiany';
            else
               $v->warning = 'Nie udało się zapisać zmian ';
            
         }
      }
   
   }
   
   function edytuj() {
      $this->controller->setTemplate('pokaz_ekrany');
      $v = $this->view;
      
      if ($this->login->getRole() >= R_MASTER) {
         $v->pokaz = array(
            'id' => $this->args->get(2),
            'name' => Projekt::getName($this->args->get(2)),
         );
         $v->listaEkranow = Projekt::getEkrany($this->args->get(2));
      } else $this->controller->redirect();
   
   }
   
   function ekran() {
      $this->controller->setTemplate('pokaz_ekran');
      $v = $this->view;
      $v->kontrolki = Kontrolki::lista();
      $v->nazwaEkranu = Ekran::getName($this->args->get(2));
   }
}
