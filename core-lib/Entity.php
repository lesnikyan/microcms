<?php

namespace Mvc;

/**
 * Description of Entity
 *
 * @author Less
 */
abstract class Entity {
    
    protected static $fields = [];
    
    protected $data = [];
    
    protected static $table = null;
    
    function __construct($data = []){
        $this->setData($data);
    }
    
    public static function getFields(){
        return static::$fields;
    }
    
    public static function getTable(){
        return static::$table;
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
    
    public function setData($data){
        foreach(static::$fields as $field) {
//            p("$field :  $data[$field]");
            if(isset($data[$field])){
                $this->data[$field] = $data[$field];
            } else if(! isset($this->data[$field])){
                $this->data[$field] = null;
            }
        }
    }
    
    public static function getClass(){
        return get_called_class();
    }
    
}
