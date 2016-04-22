<?php

namespace Controller;

use Service\Ekran;
use Service\JsonResponse;
use Service\Kontrolki;
use Service\RAWResponse;
use Service\RouterAbstract;

class Ajax extends RouterAbstract
{
    function __construct($controller)
    {
        $renderer = new JsonResponse();
        $controller->setRenderer($renderer);
        $controller->noRender = true;
        return parent::__construct($controller);
    }

    function __destruct()
    {
        $this->view->display();
    }

    function index()
    {
        $this->view->assign('message', 'niepoprawne wywołanie');
    }

    function propsDo()
    {

    }

    function props()
    {
        $v = $this->view;
        $id = $this->args->get(2); // id komponentu
        $komponent = Kontrolki::get($id);
        $v->komponent = $komponent;
    }

    function saveCommentDo()
    {
        $id = $this->args->get(2); // id komponentu
        $login = $this->login->getLogin();
        Ekran::saveComment($id, $login, $_POST['txt']);
    }

    function saveComment()
    {
        $rawRenderer = new RAWResponse();
        $this->controller->setRenderer($rawRenderer);
        $this->view = $rawRenderer;

        $id = $this->args->get(2); // id komponentu
        $comments = Ekran::getComments($id);
        $this->view->setResponse($comments);
    }

}
