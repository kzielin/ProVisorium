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

require __DIR__ . '/app/UserRoles.php';

   /* widok */
   $renderer = new Renderer();

   /* konfiguracja widoku */
   $renderer
       ->setTemplateDir($config['template_dir'])
       ->setCompileDir($config['cache_dir'].'/smarty/compile')
       ->setCacheDir($config['cache_dir'].'/smarty/cache')
       ->setCaching(Smarty::CACHING_OFF);

   $renderer
       ->assign([
           'R_ALL' => R_ALL,
           'R_USER' => R_USER,
           'R_MASTER' => R_MASTER,
           'R_ADMIN' =>  R_ADMIN,
           'config' =>  $config,
       ]);

    require __DIR__ . '/app/SmartyModifiers.php';

/* kontroler */
$controller = new Controller($renderer, $config);
$controller->dispatch($uprawnienia);


