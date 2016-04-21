<?php
/**
 * Created by PhpStorm.
 * User: kzielin
 * Date: 02.04.16
 * Time: 16:28
 */

namespace Service;


use Smarty;

class Renderer extends Smarty
{
    private $debug = [];

    public function __set($key, $value)
    {
        $this->assign($key, $value);
    }

    public function messageWarning($condition, $message, $warning)
    {
        if ($condition) {
            $this->assign('message', $message);
        } else {
            $this->assign('warning', $warning);
        }
    }

    public function debug($variable, $label = '')
    {
        $this->debug = $this->debug + [$label => $variable];
        $this->assign('debug', $this->debug);
    }
}

