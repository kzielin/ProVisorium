<?php

namespace Controller;

use Service\Ekran;
use Service\Kontrolki;
use Service\Projekt;
use Service\RouterAbstract;
use Service\Themes;

class Pokaz extends RouterAbstract
{
    protected $requireLogin = true;

    function __construct($controller)
    {
        return parent::__construct($controller);
    }

    function index()
    {
        $this->controller->redirect('pokaz/lista');
    }

    function listaDo()
    {
        $v = $this->view;
        if ($this->login->getRole() >= R_USER) {

            if ($_POST['act'] == 'ren' && !empty($_POST['newName']) && Projekt::validId($_POST['showId'])) {
                $v->messageWarning(Projekt::zmienNazwe($_POST['showId'], $_POST['newName']), 'Zapisano zmiany', 'Nie udało się zapisać zmian ');
            }

            if ($_POST['act'] == 'add' && !empty($_POST['showName'])) {
                $v->messageWarning(Projekt::dodaj($_POST['showName'], $_POST['theme']), 'Dodano pokaz', 'Nie udało się dodać pokazu ');
            }

            if ($_POST['act'] == 'del' && Projekt::validId($_POST['showId'])) {
                $v->messageWarning(Projekt::usun($_POST['showId']), 'Usunięto pokaz', 'Nie udało się usunąć pokazu ');
            }
        }
    }

    function lista()
    {
        $v = $this->view;
        $v->assign('listaPokazow', Projekt::lista($this->login->getRole() >= R_MASTER ? null : $this->login->getLogin()));
        $v->assign('themes', Themes::all());
        $this->controller->setTemplate('pokaz_lista');
    }

    function edytujDo()
    {
        $v = $this->view;
        $projId = $this->args->get(2);
        if (!Projekt::validId($projId))
            $this->controller->redirect();
        if ($this->login->getRole() >= R_USER) {

            if ($_POST['act'] == 'add' && !empty($_POST['screenName'])) {
                $v->messageWarning(Projekt::dodajEkran($projId, $_POST['screenName']), 'Dodano ekran', 'Nie udało się dodać ekranu ');
            }

            if ($_POST['act'] == 'ren' && !empty($_POST['newName'])) {
                $v->messageWarning(Projekt::zmienNazweEkranu($projId, $_POST['screenId'], $_POST['newName']), 'Zapisano zmiany', 'Nie udało się zapisać zmian ');
            }

            if ($_POST['act'] == 'del') {
                $v->messageWarning(Projekt::usunEkran($projId, $_POST['screenId']), 'Usunięto ekran', 'Nie udało się usunąć ekranu ');
            }
            if (!isset($_POST['act'])) {
                $v->messageWarning(Projekt::ustawEkran($projId, $_POST['screenId']), 'Zapisano zmiany', 'Nie udało się zapisać zmian ');
            }
        }

    }

    function edytuj()
    {
        $this->controller->setTemplate('pokaz_ekrany');
        $v = $this->view;

        if ($this->login->getRole() >= R_MASTER) {
            $v->assign('pokaz', [
                'id' => $this->args->get(2),
                'name' => Projekt::getName($this->args->get(2)),
            ]);
            $v->assign('listaEkranow', Projekt::getEkrany($this->args->get(2)));
        } else $this->controller->redirect();

    }

    function ekranDo()
    {
        $v = $this->view;
        $ekranId = $this->args->get(2);
        $v->messageWarning(Ekran::saveContent($ekranId, $_POST['item']), 'Zapisano zmiany', 'Nie udało się zapisać zmian ');
    }

    function ekran()
    {
        if ($this->login->getRole() >= R_MASTER) {
            $this->controller->setTemplate('pokaz_ekran');
            $v = $this->view;
            $ekranId = $this->args->get(2);
            $projectId = Ekran::getProjectId($ekranId);
            $pokaz = Projekt::get($projectId);

            $v->assign('idEkranu', $ekranId);
            $v->assign('ekran', Ekran::getContent($ekranId));
            $v->assign('pokaz', $pokaz);
            $v->assign('theme', Themes::get($pokaz['theme']));
            $v->assign('kontrolki', Kontrolki::lista($pokaz['theme']));
            $v->assign('nazwaEkranu', Ekran::getName($ekranId));
            $v->assign('listaEkranow', Projekt::getEkrany($projectId));
        } else $this->controller->redirect();
    }

    function uruchom()
    {
        $this->controller->setTemplate('show');


        $projectId = $this->args->getInt(2);
        if (!Projekt::validId($projectId))
            return $this->controller->redirect();

        $project = Projekt::get($projectId);
        if (!$project)
            return $this->controller->redirect();

        $ekranId = $this->args->getInt(3);
        if (empty($ekranId)) $ekranId = Projekt::getDefaultScreenId($projectId);
        $ekran = Ekran::getContent($ekranId);

        if (!$ekran)
            return $this->controller->redirect();

        $nazwaEkranu = Ekran::getName($ekranId);

        $theme = Themes::get($project['theme']);
        $kontrolkiLista = Kontrolki::lista($project['theme']);
        $kontrolki = array();
        foreach ($kontrolkiLista as $item) {
            $kontrolki[$item['id']] = $item;
        }

        $html = '';
        foreach ($ekran as $item) {
            $kontrolka = $kontrolki[$item['component_id']];
            if ($kontrolka) {
                $elem = $kontrolka['html'];
                $props = json_decode(base64_decode($item['props']), true);
                if (is_array($props)) {
                    foreach ($props as $key => $val) {
                        $elem = preg_replace("/(#$key)([^a-zA-Z0-9_])/", "$val\\2", $elem);
                    }

                    $html .= <<<HREF
                    <a class="component component_{$kontrolka[name]}"
                        data-id="{$item[id]}"
                        style="position: absolute; top:{$props[y]}px;left:{$props[x]}px;width:{$props[w]}px;height:{$props[h]}px"
HREF;
                    if ($props['link'] > 0 ) $html .= <<<LINK
                    onclick="return elementClicked(this)" href="/pokaz/uruchom/{$projectId}/{$props[link]}"
LINK;
                    $html .= ">";
                    $comments = Ekran::getComments($item['id']);
                    $hasComments = empty($comments) ? '' : 'have-comments';
                    $html .= <<<COMMENTS
                            <div style="left:{$props[w]}px" class="comments-wrapper {$hasComments}">
                                <div class="comments">
                                    {$comments}
                                </div>
                                <div class="comments-input">
                                    <textarea class="autoheight" rows="1" 
                                    placeholder="Dodaj komentarz"></textarea>
                                </div>
                            </div>
COMMENTS;
                    $html .= $elem;
                    $html .= "</a>";
                }
            }
        }

        $v = $this->view;
        $data = array(
            'pokaz' => $project,
            'ekranId' => $ekranId,
            'nazwaEkranu' => $nazwaEkranu,
            'theme' => $theme,
            'html' => $html,
            'kontrolki' => $kontrolki,
        );

        $v->assign($data);
    }

}
