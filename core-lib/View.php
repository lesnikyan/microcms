<?php

namespace Mvc;

/**
 * Description of View
 *
 * @author Less
 */
class View {
    
    protected $data = [];
    
    protected $tpl;
    
    protected static $viewDir = APP_DIR . '/views/';


    public function __construct($tpl, $data=[]) {
        $this->tpl = $tpl;
        $this->data = $data;
    }
    
    public function __set($key, $val){
        $this->data[$key] = $val;
    }
    
    public function render($printNow = false){
        extract($this->data);
        $code = file_get_contents(static::$viewDir . $this->tpl. '.php');
        ob_start();
        eval('?>' . $code . '<?php ');
        $out = ob_get_contents();
        ob_end_clean();
        if($printNow){
            print $out;
        }
        return $out;
    }
    
}
