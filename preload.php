<?php

/*
 * Load any neccessary files: app constants, core, libs etc.
 */

define('SERVER_ROOT', __DIR__);
define('CORE_DIR', SERVER_ROOT . '/core-lib');
define('APP_DIR', SERVER_ROOT . '/app');
define('CONTROLLER_DIR', APP_DIR . '/controllers');


$coreLibs = [
    'funcs', '../conf', 'Request', 'Controller', 'Model', 'Entity', 'View', 'Mvc', 'autoloader'
];

foreach($coreLibs as $n){
    require_once CORE_DIR . '/' . $n. '.php';
}

//$user = new Db\Entity\User();
//vd($user);
//p($user->getFields());
//$ouser = new Db\Entity\OtherUser();
//p($ouser->getFields());
////p($coreLibs);
//$asc = ['name' => 'Vasya', 12 => ((object)['aaaaa' => 'bbbb', 'ccc' => 'ddd']), ['qqq','wwww','eeee']];
//
//p($asc);
//pr($asc);
//vd($asc);