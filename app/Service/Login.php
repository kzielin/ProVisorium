<?php
namespace Service;
class Login
{
    private $login = '';
    private $haslo = '';
    private $rola = 0;
    private $logged = false;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!is_object($_SESSION['loginObject'])) $_SESSION['loginObject'] = new self;
        return $_SESSION['loginObject'];
    }

    static function chgPass($login, $stareHaslo, $noweHaslo)
    {
        $db = Db::getInstance();
        $stareHaslo = self::hashPass($login, $stareHaslo);
        $noweHaslo = self::hashPass($login, $noweHaslo);
        $login = addslashes($login);
        $db->exec("UPDATE users SET pass = '$noweHaslo' WHERE login = '$login' AND pass = '$stareHaslo';");
        return $db->changes();
    }

    static function lista()
    {
        $db = Db::getInstance();
        return Db::fetch_all($db->query("SELECT login, rola FROM users ORDER BY rola DESC, login"));
    }

    static function del($login)
    {
        $db = Db::getInstance();
        $login = addslashes($login);
        $db->exec("DELETE FROM users WHERE login = '$login'");
        return $db->changes();
    }

    static function projekty($login)
    {
        $db = Db::getInstance();
        $login = addslashes($login);
        return Db::fetch_all($db->query("SELECT project FROM users2projects WHERE login = '$login'"));
    }

    static function setProjects($login, $projects)
    {
        $db = Db::getInstance();
        $login = addslashes($login);
        $db->exec("DELETE FROM users2projects WHERE login = '$login'");
        if (is_array($projects))
            foreach ($projects as $p)
                $db->exec("INSERT INTO users2projects VALUES ('$login', '$p');");
    }

    function login($login, $haslo)
    {
        $db = Db::getInstance();

        if ($this->count() == 0) $this->add($login, $haslo, true);

        $haslo = $this->hashPass($login, $haslo);
        $this->haslo = $haslo;
        $login = addslashes($login);
        $this->login = $login;
        $r = $db->querySingle("SELECT rola FROM users WHERE login = '$login' AND pass = '$haslo'");
        $this->logged = false;
        if (!empty($r)) {
            $this->logged = true;
            $this->rola = (int)$r;
        }
        return $this->logged;
    }

    static function count()
    {
        $db = Db::getInstance();
        return $db->querySingle("SELECT COUNT(*) AS ile FROM users");
    }

    static function add($login, $haslo, $rola = 1)
    {
        $db = Db::getInstance();
        $haslo = self::hashPass($login, $haslo);
        $login = addslashes($login);
        if (!is_int($rola)) return false;
        return @$db->exec("INSERT INTO users VALUES ('$login', '$haslo', $rola);");
    }

    private function hashPass($login, $haslo)
    {
        return md5(md5($login) . md5($haslo));
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

    function getLogin()
    {
        return $this->login;
    }

    private function __clone()
    {
    }
}

