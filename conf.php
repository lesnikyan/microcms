<?php

namespace Mvc;

class Conf {
    
    const MainController = 'Main';
    
    const MainMethod = 'index';
    
    const host = 'micro.cms';
    
    // 'mysql:'
    const dbConnectionString = 'mysql:dbname=microcms;host=localhost';
    
    const dbUser = 'mysql';
    
    const dbPass = 'mysql';
    
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