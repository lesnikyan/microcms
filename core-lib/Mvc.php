<?php

namespace Mvc;

class Mvc {
    
    /**
     *
     * @var Mvc
     */
    private static $inst = null;
    
    /**
     *
     * @var Request
     */
    private $request = null;
    
    private $output = '';
    
    private function __construct() {
        $this->request = new Request();
        
    }
    
    /**
     * 
     * @return Mvc
     */
    public static function instance(){
        if(is_null(self::$inst)){
            self::$inst = new self();
        }
        return self::$inst;
    }
    
    public function load(){
        // load conf?
        // parse request
        $this->request->prepare();
    }
    
    public function execute(){
        $className = $this->request->controller != null ? $this->request->controller : Conf::MainController;
        $class = '\\Controller\\' . $className;
        $method = $this->request->method != null ? $this->request->method : Conf::MainMethod;
        $params = $this->request->params;
        if(! class_exists($class)){
            $class = '\\Controller\\SystemPages';
            $method = 'page404';
            $params = [Conf::host . $this->request->url];
        }
        if(! method_exists($class, $method)){
            $class = '\\Controller\\SystemPages';
            $method = 'page404';
            $params = [Conf::host . $this->request->url];
        }
        $inst = new $class();
        
        pr($params);
        $this->execController($inst, $method, $params);
    }
    
    private function execController($inst, $method, $params){
        ob_start();
        call_user_func_array([$inst, 'beforeAction'], $params);
        call_user_func_array([$inst, $method], $params);
        call_user_func_array([$inst, 'afterAction'], $params);
        $this->output = ob_get_contents();
        ob_end_clean();
    }
    
    public function render(){
        print $this->output;
    }
    
}