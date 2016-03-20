<?php

class Login
{
   private $login = '';
   private $haslo = '';
   private $rola = 0;
   private $logged = false;
   
   private function __construct() {}
   private function __clone(){} 
   
   public static function getInstance() {
      if (!is_object($_SESSION['loginObject'])) $_SESSION['loginObject'] = new self;
      return $_SESSION['loginObject'];
   }
   
   private function hashPass($login,$haslo)
   {
      return md5(md5($login).md5($haslo));
   }
   
	function login($login, $haslo)
	{
      $db = db::getInstance();

      if ($this->count() == 0) $this->add($login, $haslo, true);

      $haslo = $this->hashPass($login,$haslo); $this->haslo = $haslo;
      $login = addslashes($login);             $this->login = $login;
      $r = $db->querySingle("SELECT rola FROM users WHERE login = '$login' AND pass = '$haslo'");
      $this->logged = false;
      if (!empty($r))
      {
         $this->logged = true;
         $this->rola = (int)$r;
      } 
      return $this->logged;
	}
   
   function logout()
   {
      $this->logged = false;
      $this->rola = 0;
      $this->login = '';
      $this->haslo = '';
      unset($_SESSION['loginObject']);
   }
   
   function logged()
   {
      return $this->logged;
   }
   
   function getRole()
   {
      return $this->rola;
   }
   
   static function add($login, $haslo, $rola = 1)
   {
      $db = db::getInstance();
      $haslo = self::hashPass($login,$haslo);
      $login = addslashes($login);
      if (!is_int($rola)) return false;
      return @$db->exec("INSERT INTO users VALUES ('$login', '$haslo', $rola);");
   }
   
   static function chgPass($login, $stareHaslo, $noweHaslo) {
      $db = db::getInstance();
      $stareHaslo = self::hashPass($login,$stareHaslo);
      $noweHaslo  = self::hashPass($login,$noweHaslo);
      $login = addslashes($login);
      $db->exec("UPDATE users SET pass = '$noweHaslo' WHERE login = '$login' AND pass = '$stareHaslo';");
      return $db->changes();
   }
   
   static function count()
   {
      $db = db::getInstance();
      return $db->querySingle("SELECT COUNT(*) AS ile FROM users");
   }
   
   static function lista()
   {
      $db = db::getInstance();
      return db::fetch_all($db->query("SELECT login, rola FROM users ORDER BY rola DESC, login"));
   }
   
   static function del($login)
   {
      $db = db::getInstance();
      $login = addslashes($login);
      $db->exec("DELETE FROM users WHERE login = '$login'");
      return $db->changes();
   }
   
   static function projekty($login)
   {
      $db = db::getInstance();
      $login = addslashes($login);
      return db::fetch_all($db->query("SELECT project FROM users2projects WHERE login = '$login'"));
   }
   
   static function setProjects($login, $projects)
   {
      $db = db::getInstance();
      $login = addslashes($login);
      $db->exec("DELETE FROM users2projects WHERE login = '$login'");
      if (is_array($projects)) 
         foreach ($projects as $p)
            $db->exec("INSERT INTO users2projects VALUES ('$login', '$p');");
   }
   
   function getLogin()
   {
      return $this->login;
   }
}

