<?php
namespace Service;
use Exception;
use Smarty;

class Controller
{
   var $args;
   var $login;
   var $template;
   var $noRender;
   /**
    * @var Smarty $view
    */
   var $view;
   /**
    * @var array
    */
   private $config;

   /**
    * Controller constructor.
    * @param Smarty $view
    * @param array $config
    */
   function __construct(Smarty $view, $config)
	{
       $this->args = new Args();
       $this->login = Login::getInstance();
       $this->view = $view;
       $this->config = $config;
    }

   function redirect($where = '') {
      header('Location: '.$this->config['base_href'].$where);
      exit;
   }
   
   function want($level = 0)
   {
      $want = $this->args->get($level);
      if (empty($want))
         $want = 'index';
      return $want;
   }
   
   function setTemplate($template) {
      $this->template = $template;
   }
   function setNoRender($noRender) {
      $this->noRender = $noRender;
   }
   
   function dispatch($uprawnienia = null)
   {
      $zadanyModel   = $this->want(0);
      $zadanaAkcja   = $this->want(1);
      $zadanaAkcjaDo = $zadanaAkcja.'Do';
      
      // sprawdzanie uprawnień do tej części aplikacji
      $uruchamianyModel = 'index';
      if (is_array($uprawnienia)) {
         if (isset($uprawnienia[$zadanyModel])) {
            if ($uprawnienia[$zadanyModel] <= $this->login->getRole())
               $uruchamianyModel = $zadanyModel;
         } 
      }
      
      $this->view->assign('rola', $this->login->getRole());
      
      // domyślnie wyświetlany szablon o takiej samej nazwie jak Model
      $this->template = $uruchamianyModel;
      
      // zapamiętanie zmiennych obiektu widoku, do późniejszego porównania
      $t_zmienneWidoku = get_object_vars($this->view);
      
      try {
         $modelWithNamespace = '\\Controller\\' . ucfirst($uruchamianyModel);
         $controller = new $modelWithNamespace($this);
      } catch (Exception $e) {
         die ($e->getMessage());
      }
      
      if (!empty($_POST) && in_array($zadanaAkcjaDo, get_class_methods($controller)))
         $controller->$zadanaAkcjaDo();

      if (in_array($zadanaAkcja, get_class_methods($controller)))
         $controller->$zadanaAkcja();
      
      // przepisywanie dodanych zmiennych obiektu widoku do zmiennych widoku
      foreach (get_object_vars($this->view) as $var=>$value)
         if (!isset($t_zmienneWidoku[$var]) && !empty($value))
            $this->view->assign($var, $value);

      if (!$this->noRender) {
         $this->view->display('_header.tpl');
         $this->view->display($this->template.'.tpl');
         $this->view->display('_footer.tpl');      
      }
   }
}