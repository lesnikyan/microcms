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
    
    protected $__defaultContent = '[ NO CONTENT ]';
    
    protected static $viewDir;

    public function __construct($tpl=null, $data=[]) {
        self::$viewDir = APP_DIR . '/views/';
        $this->tpl = $tpl;
        if(is_string($data)){
            $this->data['content'] = $data;
        } else {
            $this->data = $data;
        }
    }
    
    public function __set($key, $val){
        $this->data[$key] = $val;
    }
    
    public function render($printNow = false){
        if(! $this->tpl){
            $content = (isset($this->data['content']) ? $this->data['content'] : $this->__defaultContent);
            return $this->out($content, $printNow);
        }
        extract($this->data);
        $code = file_get_contents(static::$viewDir . $this->tpl. '.php');
        ob_start();
        eval('?>' . $code . '<?php ');
        $out = ob_get_contents();
        ob_end_clean();
        return $this->out($out, $printNow);
    }
    
    protected function out($content, $printNow){
        if($printNow){
            print $content;
        }
        return $content;
    }
    
}
