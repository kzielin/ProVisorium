<?php
namespace Service;
class Themes
{
   function __construct()
   {
   }

   static function all()
   {
      $result = [];
      $db = Db::getInstance();
      $all = Db::fetch_all($db->query("SELECT * FROM themes ORDER BY name"));
      foreach ($all as $item) {
         $result[$item['id']] = $item;
      }
      return $result;
   }
   
   static function add($name, $width, $height)
   {
      $db = Db::getInstance();
      $name = Db::escape($name);
      $width = (int)$width;
      $height = (int)$height;
      $db->exec("INSERT INTO themes (name, width, height) VALUES ( '$name', $width, $height);");
      return $db->changes();
   }
   
   static function del($id)
   {
      $db = Db::getInstance();
      $db->exec("DELETE FROM themes WHERE id = '$id'");
      return $db->changes();
   }
   
   static function rename($id, $nowaNazwa)
   {
      $db = Db::getInstance();
      $nowaNazwa = Db::escape($nowaNazwa);
      $db->exec("UPDATE themes SET name = '$nowaNazwa' WHERE id = '$id'");
      return $db->changes();
   }
   
   static function validId($id)
   {
      $db = Db::getInstance();
      if (!is_numeric($id)) return false;
      return $db->querySingle("SELECT COUNT(*) FROM themes WHERE id = '$id'") == 1;
   }
   
   static function get($id)
   {
      $db = Db::getInstance();
      if (!self::validId($id)) return false;
      $res = $db->querySingle("SELECT * FROM themes WHERE id = '$id'", true);
      return $res;
   }

}
