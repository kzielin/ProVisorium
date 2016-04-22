<?php
/**
 * Created by PhpStorm.
 * User: kzielin
 * Date: 02.04.16
 * Time: 16:28
 */

namespace Service;

class RAWResponse extends Renderer
{
    private $response = '';
    public function __set($key, $value) {

    }
    public function assign($key, $value) {

    }
    public function setResponse($txt) {
        $this->response = $txt;
    }
    public function messageWarning($condition, $message, $warning) {

    }
    public function fetch() {
        return $this->response;
    }
    public function display() {
        echo $this->fetch();
    }
}

