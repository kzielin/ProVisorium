<?php
namespace Controller;
use Service\Db;

class Projekt
{
	function __construct()
	{
	}
   
   static function lista($login = null) /**/
   {
      $db = Db::getInstance();
      if (is_null($login))
         $r = $db->query("SELECT * FROM projects ORDER BY name");
      else
         $r = $db->query("SELECT * FROM projects WHERE id = (SELECT project FROM users2projects WHERE login = '$login' )  ORDER BY name");
      return Db::fetch_all($r);
   }
   
   static function dodaj($nazwa) /**/
   {
      $db = Db::getInstance();
      $nazwa = Db::escape($nazwa);
      $db->exec("INSERT INTO projects (name) VALUES ('$nazwa');");
      return $db->changes();
   }
   
   static function usun($id) /**/
   {
      $db = Db::getInstance();
      $db->exec("DELETE FROM users2projects WHERE project = '$id'");
      $db->exec("DELETE FROM projects WHERE id = '$id'");
      return $db->changes();
   }
   
   static function zmienNazwe($id, $nowaNazwa) /**/
   {
      $db = Db::getInstance();
      $nowaNazwa = Db::escape($nowaNazwa);
      $db->exec("UPDATE projects SET name = '$nowaNazwa' WHERE id = '$id'");
      return $db->changes();
   }
   
   static function validId($id) /**/
   {
      $db = Db::getInstance();
      if (!is_numeric($id)) return false;
      return $db->querySingle("SELECT COUNT(*) FROM projects WHERE id = '$id'") == 1;
   }
   
   static function getName($id) /**/
   {
      $db = Db::getInstance();
      if (!self::validId($id)) return false;
      return $db->querySingle("SELECT name FROM projects WHERE id = '$id'");
   }
   
   static function getEkrany($id) {
      $db = Db::getInstance();
      if (!self::validId($id)) return false;
      $r = $db->query("SELECT * FROM screens WHERE projectId = '$id' ORDER BY name");   
      return Db::fetch_all($r);
   }
   
   static function dodajEkran($projectId,$screenName) {
      $db = Db::getInstance();
      if (!self::validId($projectId)) return false;
      $isMain = sizeof(self::getEkrany($projectId)) == 0 ? 1 : 0;
      $screenName = Db::escape($screenName);
      $db->exec("INSERT INTO screens (name, projectId, isMain) VALUES ('$screenName', $projectId, $isMain)");
      return $db->changes();
   }
   
   static function usunEkran($projectId, $screenId) {
      $db = Db::getInstance();
      if (!self::validId($projectId)) return false;
      $db->exec("DELETE FROM screens WHERE id = $screenId AND projectId = $projectId");
      return $db->changes();
   }
   
   static function zmienNazweEkranu($projectId, $screenId, $nowaNazwa) {
      $db = Db::getInstance();
      if (!self::validId($projectId)) return false;
      $nowaNazwa = Db::escape($nowaNazwa);
      $db->exec("UPDATE screens SET name = '$nowaNazwa' WHERE id = $screenId AND projectId = $projectId");
      return $db->changes();
   }
   
   static function ustawEkran($projectId, $screenId) {
      $db = Db::getInstance();
      if (!self::validId($projectId)) return false;
      $db->exec("UPDATE screens SET isMain = (id = $screenId) WHERE projectId = $projectId");
      return $db->changes();
   }
}
