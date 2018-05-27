<?php

namespace Controller;
use \Mvc\View;

class Main extends \Mvc\Controller {
    
    public function index() {
        $view = new View('main');
        $view->body = 'Hello from Main page!';
        $view->render(true);
    }
    
    public function test(){
        p("Main : test");
    }

}