<?php

// role użytkowników
define('R_ALL', 0);
define('R_USER', 1);
define('R_MASTER', 2);
define('R_ADMIN', 3);

// uprawnienia ról
$uprawnienia = [
    'start' => R_USER,
    'logowanie' => R_ALL,
    'ajax' => R_ALL,
    'uzytkownicy' => R_ADMIN,
    'komponenty' => R_USER,
    'motywy' => R_USER,

    'edycja' => R_MASTER,
    'pokaz' => R_ALL,
    'ekran' => R_ALL,
];