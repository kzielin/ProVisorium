<?php

use Service\Controller;
use Service\Renderer;

error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);

require __DIR__ . '/vendor/autoload.php';
session_start();

$whoops = new Whoops\Run();
$whoopsHandler = new Whoops\Handler\PrettyPageHandler();
$whoopsHandler->setEditor("phpstorm");
$whoops->pushHandler($whoopsHandler);
$whoops->register();

$config = (new Symfony\Component\Yaml\Yaml())->parse(file_get_contents('config/app.yml'));

define('DB_FILE', __DIR__.'/'.$config['database_file']);

// role użytkowników
define('R_ALL', 0);
define('R_USER', 1);
define('R_MASTER', 2);
define('R_ADMIN', 3);

// uprawnienia ról
$uprawnienia = [
    'start' => R_USER,
    'logowanie' => R_ALL,
    'uzytkownicy' => R_ADMIN,
    'komponenty' => R_USER,

    'edycja' => R_MASTER,
    'pokaz' => R_ALL,
    'ekran' => R_ALL,
];

/* widok */
$smarty = new Renderer();
   /* konfiguracja widoku */
   $smarty
       ->setTemplateDir($config['template_dir'])
       ->setCompileDir($config['cache_dir'].'/smarty/compile')
       ->setCacheDir($config['cache_dir'].'/smarty/cache')
       ->setCaching(Smarty::CACHING_OFF);

   $smarty
       ->assign([
           'R_ALL' => R_ALL,
           'R_USER' => R_USER,
           'R_MASTER' => R_MASTER,
           'R_ADMIN' =>  R_ADMIN,
           'config' =>  $config,
       ]);

/* pluginy smarty */
function smarty_modifier_contains($haystack, $needle)
{
    return strpos($haystack, $needle) !== false;
}
function smarty_modifier_base64encode($string)
{
    return base64_encode($string);
}

/* kontroler */
$controller = new Controller($smarty, $config);
$controller->dispatch($uprawnienia);


