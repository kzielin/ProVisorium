<?php 

include(__DIR__.'/db/config.php');

/* view */   
$v = new Smarty();
   /* konfiguracja widoku */
   $v->template_dir = T;
   $v->compile_dir = SMARTY_COMPILE_DIR;
   $v->cache_dir = SMARTY_CACHE_DIR;
   $v->allow_php_tag = true;
   $v->caching = 0;
   $v->compile_check = COMPILE_CHECK;
   
   $v->assign('R_USER',   R_USER  );
   $v->assign('R_MASTER', R_MASTER);
   $v->assign('R_ADMIN',  R_ADMIN );
   
/* controller */
$c = new Controller($v);
/** @var array $uprawnienia */
$c->dispatch($uprawnienia);


