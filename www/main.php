<?php

/*
 * Start file of project
 * 
 */

require_once '../preload.php';

use Mvc\Mvc;

try {
    
    $core = Mvc::instance();

    $core->load();

    $core->execute();

    $core->render();
    
} catch (Exception $e){
    p($e->getTraceAsString());
}