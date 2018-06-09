<?php

$app->session = function () {
    $session = new src\Library\Session\AppSession();
    return $session;
};




