<?php

namespace Mvc;

abstract class Controller {
    
    abstract function index();
    
    function beforeAction(){}
    
    function afterAction(){}
    
}
