<?php

namespace Controller;

use Service\Ekran;
use Service\Kontrolki;
use Service\Projekt;
use Service\RouterAbstract;
use Service\Themes;

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
            $v->messageWarning(Projekt::zmienNazwe($_POST['showId'], $_POST['newName']), 'Zapisano zmiany','Nie udało się zapisać zmian ');
         }
         
         if ($_POST['act']=='add' && !empty($_POST['showName'])) {
            $v->messageWarning(Projekt::dodaj($_POST['showName'], $_POST['theme']),'Dodano pokaz','Nie udało się dodać pokazu ');
         }
         
         if ($_POST['act']=='del' && Projekt::validId($_POST['showId'])) {
            $v->messageWarning(Projekt::usun($_POST['showId']),'Usunięto pokaz','Nie udało się usunąć pokazu ');
         }
      }
   }
   
   function lista() {
      $v = $this->view;
      $v->assign('listaPokazow',Projekt::lista( $this->login->getRole() >= R_MASTER ? null : $this->login->getLogin()));
      $v->assign('themes', Themes::all());
      $this->controller->setTemplate('pokaz_lista');
   }

   function edytujDo() {
      $v = $this->view;
      $projId = $this->args->get(2);
      if (!Projekt::validId($projId))
         $this->controller->redirect();
      if ($this->login->getRole() >= R_USER) {
      
         if ($_POST['act']=='add' && !empty($_POST['screenName'])) {
            $v->messageWarning(Projekt::dodajEkran($projId,$_POST['screenName']),'Dodano ekran','Nie udało się dodać ekranu ');
         }
         
         if ($_POST['act']=='ren' && !empty($_POST['newName'])) {
            $v->messageWarning(Projekt::zmienNazweEkranu($projId, $_POST['screenId'], $_POST['newName']),'Zapisano zmiany','Nie udało się zapisać zmian ');
         }
         
         if ($_POST['act']=='del') {
            $v->messageWarning(Projekt::usunEkran($projId, $_POST['screenId']),'Usunięto ekran','Nie udało się usunąć ekranu ');
         }
         if (!isset($_POST['act'])) {
            $v->messageWarning(Projekt::ustawEkran($projId, $_POST['screenId']),'Zapisano zmiany','Nie udało się zapisać zmian ');
         }
      }
   
   }
   
   function edytuj() {
      $this->controller->setTemplate('pokaz_ekrany');
      $v = $this->view;
      
      if ($this->login->getRole() >= R_MASTER) {
         $v->assign('pokaz', [
            'id' => $this->args->get(2),
            'name' => Projekt::getName($this->args->get(2)),
         ]);
         $v->assign('listaEkranow', Projekt::getEkrany($this->args->get(2)));
      } else $this->controller->redirect();
   
   }
   
   function ekran() {
      $this->controller->setTemplate('pokaz_ekran');
      $v = $this->view;
      $v->assign('kontrolki', Kontrolki::lista());
      $v->assign('nazwaEkranu', Ekran::getName($this->args->get(2)));
   }
}
