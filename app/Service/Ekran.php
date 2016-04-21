<?php
namespace Service;
class Ekran
{
    function __construct()
    {
    }


    static function validId($id) /**/
    {
        $db = Db::getInstance();
        if (!is_numeric($id)) return false;
        return $db->querySingle("SELECT COUNT(*) FROM screens WHERE id = '$id'") == 1;
    }

    static function getName($id) /**/
    {
        $db = Db::getInstance();
        if (!self::validId($id)) return false;
        return $db->querySingle("SELECT name FROM screens WHERE id = '$id'");
    }

    static function getProjectId($id)
    {
        $db = Db::getInstance();
        if (!self::validId($id)) return false;
        return $db->querySingle("SELECT projectId FROM screens WHERE id = '$id'");
    }

    static function clear($id)
    {
        $db = Db::getInstance();
        if (!self::validId($id)) return false;
        return $db->querySingle("DELETE FROM content WHERE screen_id = '$id'");
    }

    static function saveContent($id, $data)
    {
        $db = Db::getInstance();
        if (!self::validId($id)) return false;
        if (!is_array($data)) return false;

        self::clear($id);
        foreach ($data as $lp => $item) {
            $lp = (int)$lp;
            $item = Db::escape($item);
            list($type, $props) = explode('|', $item);
            $db->querySingle("INSERT INTO content (screen_id, component_id, lp, props) " .
                " VALUES ($id, $type, $lp, '$props')");
        }
        return true;

    }

    static function getContent($id) {
        $db = Db::getInstance();
        if (!self::validId($id)) return false;
        $r = $db->query("SELECT * FROM content WHERE screen_id = '$id' ORDER BY lp");
        return Db::fetch_all($r);
    }
}