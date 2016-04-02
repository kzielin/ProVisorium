<?php
namespace Service;
class Ekran
{
	function __construct()
	{
	}
   
   
   static function validId($id) /**/
   {
      $db = Db::getInstance();
      if (!is_numeric($id)) return false;
      return $db->querySingle("SELECT COUNT(*) FROM screens WHERE id = '$id'") == 1;
   }
   
   static function getName($id) /**/
   {
      $db = Db::getInstance();
      if (!self::validId($id)) return false;
      return $db->querySingle("SELECT name FROM screens WHERE id = '$id'");
   }
}