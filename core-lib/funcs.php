<?php

function p($var='#'){
        $str = '';
    if(is_object($var)){
        $str = objToStr($var);
    } else if(is_array($var)){
        $str = arrToStr($var);
    } else if(is_string($str)) {
        // just string
        $str = $var;
    } else {
        $str = objToStr($var);
    }
    print "<div><pre>\n{$str}\n</pre></div>\n";
}

function objToStr($var, $toString = false){
    $t = '';
    if(is_object($var)){
        if($toString && method_exists($var, '__toString')){
            return (string) $var;
        } else {
            return print_r($var, true);
        }
    } else if(is_array($var)){
        if($toString){
            return arrToStr($var);
        }
        return print_r($var, true);
    } else if(is_string($var)){
        return "'$var'";
    } else if(is_bool($val)){
        return ($var ? 'TRUE' : 'FALSE');
    } else if(is_null($var)){
        return 'NULL';
    } else {
        return $var;
    }
}

function arrToStr($var){
    $arr = [];
    foreach($var as $key => $val){
        $t = objToStr($val);
        $key = is_string($key) ? "'$key'" : $key;
        $arr[] = "$key => $t";
    }
    $str = implode(', ', $arr);
    return "[$str]";
}

function pr($var){
    $str = objToStr($var);
    print "<div><pre>\n{$str}\n</pre></div>\n";
}

function vd($var){
    print "<div><pre>\n";
    var_dump($var);
    print "\n</pre></div>\n";
}

function html_table($data, $style){
    
}