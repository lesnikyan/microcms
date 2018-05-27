<?php

namespace Db;

/**
 * Description of Entity
 *
 * @author Less
 */
class Entity {
    
    protected static $fields = [];
    
    protected $data = [];
    
    protected static $table = null;
    
    public static function getFields(){
        return static::$fields;
    }
    
    public function __get($key){
        if(in_array($key, static::$fields) && isset($this->data[$key])){
            return $this->data[$key];
        }
    }
    
    public function __set($key, $val){
        if(in_array($key, static::$fields)){
            $this->data[$key] = $val;
        }
    }
    
    public function getData(){
        return $this->data;
    }
    
}
