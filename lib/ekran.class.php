<?php

class Ekran
{
	function __construct()
	{
	}
   
   
   static function validId($id) /**/
   {
      $db = db::getInstance();
      if (!is_numeric($id)) return false;
      return $db->querySingle("SELECT COUNT(*) FROM screens WHERE id = '$id'") == 1;
   }
   
   static function getName($id) /**/
   {
      $db = db::getInstance();
      if (!self::validId($id)) return false;
      return $db->querySingle("SELECT name FROM screens WHERE id = '$id'");
   }
}