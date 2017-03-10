<?php

namespace Application\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class UserSessionPlugin extends AbstractPlugin {

    
    protected $sessionService;
    protected $userdata;

    public function setSessionService($sessionService){
        $this->sessionService = $sessionService;
        
    }
    
    public function __invoke($name=null) {
        
        $this->userdata=$this->sessionService->$name;
        
        return $this->userdata;
    }

}
