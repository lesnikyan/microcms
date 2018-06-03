<?php


class r {
    
    public static function get($key){
        return self::fromArray($_GET, $key);
    }
    
    public static function post($key){
        return self::fromArray($_POST, $key);
    }
    
    public static function fromPost($keys){
        return array_intersect_key($_POST, array_flip($keys));
    }
    
    public static function fromArray($arr, $key){
        return isset($arr[$key]) ? $arr[$key] : null;
    }
    
    /**
     * 
     * @param string $url - full URL, or local path like: /user/info
     */
    public static function redirect($url){
        if(! preg_match('#^http://#', $url)){
            $url = 'http://' .  Mvc\Conf::host . $url;
        }
        header('Location: ' . $url);
    }
    
}

class session {
    
    public static function start(){
        session_start();
    }
    
    public static function set($key, $val){
        $_SESSION[$key] = $val;
    }
    
    public static function get($key){
        return r::fromArray($_SESSION, $key);
    }
    
    public static function del($key){
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }
    
}

class cookie {
    
    public static function get($key){
        return r::fromArray($_COOKIE, $key);
    }
    
    public static function set($key, $val, $expire = 0, $path = '/'){
        setcookie($key, $val, $expire, $path);
    }
    
    public function has($key){
        return isset($_COOKIE[$key]);
    }
    
    public static function del($key){
        if(isset($_COOKIE[$key])){
            self::set($key, 0, 1);
        }
    }
    
}

class files {
    
    const FORM_ATTRIBUTE = 'enctype="multipart/form-data"';
    
    public static function keys(){
        return array_keys($_FILES);
    }
    
    public static function names(){
        $t = [];
        foreach($_FILES as $key => $f){
            $t[$key] = $f['name'];
        }
        return $t;
    }
    
    public static function has($key){
        return isset($_FILES[$key]);
    }
    
    public static function move($key, $path){
        if(self::has($key)){
            return move_uploaded_file($_FILES[$key]['tmp_name'], $path);
        }
        return false;
    }
    
    public static function data($key = null){
        if(is_null($key)){
            return $_FILES;
        }
        return r::fromArray($_FILES, $key);
    }
    
}
