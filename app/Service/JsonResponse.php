<?php
/**
 * Created by PhpStorm.
 * User: kzielin
 * Date: 02.04.16
 * Time: 16:28
 */

namespace Service;

class JsonResponse extends Renderer
{
    private $data = [];
    public function __set($key, $value) {
        $this->assign($key, $value);
    }
    public function assign($key, $value) {
        $this->data[$key] = $value;
    }
    
    public function messageWarning($condition, $message, $warning) {
        if ($condition) {
            $this->assign('message', $message);
        } else {
            $this->assign('warning', $warning);
        }
    }
    public function fetch() {
        return json_encode($this->data);
    }
    public function display() {
        header('Content-Type: application/json');
        echo $this->fetch();
    }
}

