<?php

namespace Mvc;

class Conf {
    
    const MainController = 'Main';
    
    const MainMethod = 'index';
    
    const host = 'micro.cms';
    
    private static $data  = [
        'entityFields' => [
            'OtherUser' => 'id,login,pass,email'
        ]
    ];
    
    public static function get($key){
        if(isset(self::$data[$key])){
            return self::$data[$key];
        }
        return null;
    }
    
}