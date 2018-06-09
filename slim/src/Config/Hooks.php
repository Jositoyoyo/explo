<?php

$app->hook('slim.before', function () use ($app) {
    //$app->log->setWriter(new src\Library\Logger\Logger());
    src\Library\Session\SessionManager::sessionStart(APPSTAGE, 0, $path = '/', $_SERVER['HTTP_HOST'], $secure = null);
});
$app->hook('slim.after', function () use ($app) {
   // src\Library\Session\SessionManager::regenerateSession();
});
