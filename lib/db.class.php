<?php
class Db
{
   private static $instance;
   private function __construct(){}
   private function __clone(){}
   public static function getInstance() {
      if (!self::$instance)
         self::$instance = new SQLite3(DB_FILE) or die('nie można otworzyć bazy danych');
      return self::$instance;
   }

   public static function escape ($txt) {
      return SQLite3::escapeString($txt);
   }
   public static function fetch_all($res, $type = SQLITE_ASSOC) {
      $ret = array();
      if ($res) 
         while($row = $res->fetchArray($type))
            $ret[] = $row;
      return $ret;
   }
}