<?php

namespace Controller;
use \Mvc\View;
use \r;
use \files;

class Main extends \Mvc\Controller {
    
    public function index() {
        $view = new View('main');
        $view->body = 'Hello from Main page!';
        $view->render(true);
    }
    
    public function test(){
        p("Main : test");
    }
    
    public function form($postArg=null){
        if($postArg !== 'post'){
            return (new View('upload_form'))->render(true);
        }
        $this->handleUploadForm();
    }
    
    private function handleUploadForm(){
        if(\files::has('upfile')){
            $finfo = files::data('upfile');
            $fname = 'upl_' . microtime() . '_' . $finfo['name'];
            files::move('upfile', SERVER_ROOT . '/tmp/' . $fname);
        }
        r::redirect('/main/form');
    }

}