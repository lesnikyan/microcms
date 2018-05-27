<?php

namespace Controller;

/**
 * Description of System
 *
 * @author Less
 */
class SystemPages extends \Mvc\Controller {
    
    public function index() {
        
    }
    
    public function page404($url){
        p("Page '$url' not found");
    }

}
