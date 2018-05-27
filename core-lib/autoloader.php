<?php

spl_autoload_register(function($className){
    if(class_exists($className)){
        return;
    }
    if(preg_match('#^Mvc\\\\([\w]+)$#', $className, $m)){
        // load lib classes
    } else if(preg_match('#^Db\\\\([\w]+)$#', $className, $m)){
        // load models
        CLassLoader::loadModel($m[1]);
//        p('Loader; load models');
    } else if(preg_match('#^Db\\\\Entity\\\\([\w]+)$#', $className, $m)){
        // load db entity
//        p('Loader; load entity');
//        pr($m);
        $entity = $m[1];
        
        ClassLoader::loadEntity($entity);
    } else if(preg_match('#^\\Controller\\\\([\w]+)$#', $className, $m)){
        // load controllers
//        p('loader Controller');
        ClassLoader::loadController($m[1]);
    } else {
        // nothingp
        p('Loader; load nothing: ' . $className);
    }
});

class ClassLoader {
    
    public static function loadClass($name,  $dir){
        $path = $dir . '/' . $name . '.php';
//        p($path);
        if(file_exists($path)){
            require_once $path;
        }
    }
    
    public static function loadController($name){
        self::loadClass($name, CONTROLLER_DIR);
    }
    
    public static function loadModel(){
        self::loadClass($name, APP_DIR . '/models');
    }
    
    public static function loadEntity($entity){
        $path = APP_DIR . '/models/entities/' . $entity . '.php';
        //p($path);
        if(file_exists($path)){
            require_once $path;
            return;
        }
        $ef = Mvc\Conf::get('entityFields');
        if(! isset($ef[$entity])){
            return;
        }
        $fields = implode(', ', array_map(function($s){ return "'$s'"; }, explode(',', $ef[$entity])));
        $fieldsVar = " protected static \$fields = [{$fields}]; \n";
        $code = "namespace Db\\Entity { class {$entity} extends \\Db\\Entity { \n {$fieldsVar} } }";
//        p($code);
        eval($code);
    }
    
}
