<?php
namespace Service;
class Kontrolki
{
   const initIcon = 'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9wCBRAuGg51hoAAAAAMaVRYdENvbW1lbnQAAAAAALyuspkAAAD2SURBVFjD7dW/SoMxFIbxXwvq4CIuXaSbg5ubs6irF+Do6CZ4CcXbEPQiXBUXBRGhTuKum4gFFcS6fMPhE/zXfgliXghkCHkekpMTSv5gFrGLI9ziBQNc4wBrTYFXcIbhN8YhZsctMPzhOMdUEwI36GEVHUyii3Wc1CR2xilwXEE/Swt7QeAiR5F2g8Dgq8XtBgQew/w1h8B2mPdTHv1E1R9iEW6mgi/gqgY/beiEP2QZ9zX4HeZSwJfwVIP3MZ8CPlP9BRG+j+lU994L4GdspG44l0FgK0fHewgCnRwCb0Hg18+tNeLvOPI+bSX/PaUIi0BJ9rwDdORXdL0zYJsAAAAASUVORK5CYII=';
	function __construct()
	{
	}
   
   static function lista()
   {
      $db = Db::getInstance();
      return Db::fetch_all($db->query("SELECT * FROM components ORDER BY name"));
   }
   
   static function add($name, $html = '', $css = '', $js = '', $props = array())
   {
      $db = Db::getInstance();
      $name = Db::escape($name);
      $html = Db::escape($html);
      $css = Db::escape($css);
      $js = Db::escape($js);
      $props = json_encode($props);
      $icon = self::initIcon;
      $db->exec("INSERT INTO components (name, html, css, js, props, icon) VALUES ( '$name', '$html', '$css', '$js', '$props', '$icon');");
      return $db->changes();
   }
   
   static function save($id, $html, $css, $js, $props = array(), $icon = '') {
      if (!self::validId($id)) return false;
      
      $db = Db::getInstance();
      $html = Db::escape($html);
      $css = Db::escape($css);
      $js = Db::escape($js);
      $icon = Db::escape($icon);
      $props = Db::escape(serialize($props));
      $db->exec("UPDATE components SET html = '$html', css = '$css', js = '$js', props ='$props', icon='$icon' WHERE id = $id;");
      return $db->changes();
   }
   
   static function del($id)
   {
      $db = Db::getInstance();
      $db->exec("DELETE FROM components WHERE id = '$id'");
      return $db->changes();
   }
   
   static function zmienNazwe($id, $nowaNazwa)
   {
      $db = Db::getInstance();
      $nowaNazwa = Db::escape($nowaNazwa);
      $db->exec("UPDATE components SET name = '$nowaNazwa' WHERE id = '$id'");
      return $db->changes();
   }
   
   static function validId($id)
   {
      $db = Db::getInstance();
      if (!is_numeric($id)) return false;
      return $db->querySingle("SELECT COUNT(*) FROM components WHERE id = '$id'") == 1;
   }
   
   static function get($id)
   {
      $db = Db::getInstance();
      if (!self::validId($id)) return false;
      $res = $db->querySingle("SELECT * FROM components WHERE id = '$id'", true);
      if (empty($res['props'])) $res['props'] = serialize(array());
      $res['props'] = unserialize($res['props']);
      return $res;
   }

}
