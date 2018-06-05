<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mvc;

/**
 * Description of Request
 *
 * @author Less
 * 
 * @property-read string $controller 
 * @property-read string $method
 * @property-read string $url
 * @property-read string $segments
 * @property-read string $params
 */
class Request {
    
    private $host;
    
    private $get;
    
    private $post;
    
    private $files;
    
    private $data = [];
    
    private $pubList = ['controller', 'method', 'params', 'url', 'segments'];
    
    
    public function __construct() {
        //
    }
    
    public function prepare(){
        // read url
        //pr($_SERVER);
        $this->get = $_GET;
        $this->post = $_POST;
        $this->host = $_SERVER['HTTP_HOST'];
        $url = $_SERVER['REQUEST_URI'];
        $urlParts = (parse_url($url));
        $path = $urlParts['path'];
        $query = $urlParts['query'];
        $segments = explode('/', trim($path, "/"));
//        pr($segments);
        $this->data['segments'] = $segments;
        
        if(count($segments) < 1){
            $segments[0] = Conf::MainController;
        }
        if(count($segments) < 2){
            $segments[1] = Conf::MainMethod;
        }
        list($controller, $method) = $segments;
        $params = array_slice($segments, 2);
        $this->data = [
            'controller' => ucfirst($controller),
            'method' => $method,
            'params' => $params,
            'segments' => $segments,
            'url' => $url,
//            'query' => $query
        ];
//        pr($this->data);
    }
    
    public function __get($name){
        if(in_array($name, $this->pubList) && array_key_exists($name, $this->data)){
            return $this->data[$name];
        }
    }
    
    /**
     * get current method or check expected method 
     * @param string $val - expected method (get, post, ... )
     * @return string current method, or bool if $val != null
     */
    public function method($val=null){
        $reqMethod = $_SERVER['REQUEST_METHOD'];
        if(is_null($val)){
            return $reqMethod;
        }
        return (bool)(strcasecmp($reqMethod, $val) == 0);
    }
    
}
