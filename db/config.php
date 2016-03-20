<?php
function __autoload($className) {
   $dirs = array(__DIR__.'/../lib/',__DIR__.'/../application/');
   $className = strtolower($className);
   foreach ($dirs as $M) {
      if (file_exists($M.$className.'.class.php')) return require_once($M.$className.'.class.php');
      else if ($className == 'smarty')             return require_once($M.'smarty/Smarty.class.php');
      else if (substr($className, 0, 15) == "smarty_internal")  return require_once($M."smarty/sysplugins/$className.php");
   }
}

// start sesji, konecznie po autoloaderze
session_start();

// plik bazy danych
define('DB_FILE', 'db/db.sqlite');

// do katalogów
define("I", "db/img/");
define("M", "lib/");

define("T", "templates/");
define("V", T."skin/");
define("SMARTY_CACHE_DIR", "cache/smarty/cache/");
define("SMARTY_COMPILE_DIR", "cache/smarty/compile/");

// do widoku
define("COMPILE_CHECK", true);

// ustalenie base href
define("BASE_HREF", Args::getBaseHref());

// role użytkowników
define('R_ALL', 0);
define('R_USER', 1);
define('R_MASTER', 2);
define('R_ADMIN', 3);

// uprawnienia

$uprawnienia = array(
   'start' => R_USER,
   'logowanie' => R_ALL,
   'uzytkownicy' => R_ADMIN,
   'komponenty' => R_USER,
   
   'edycja' => R_MASTER,
   'pokaz' => R_ALL,
   'ekran' => R_ALL,
);
