<?php

namespace Common\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class UserSessionPlugin extends AbstractPlugin {

    protected $sessionService;
    protected $userdata;

    public function __construct($sessionService) {
        $this->sessionService = $sessionService;
    }

    public function __invoke($name = null) {
        if (0 === func_num_args()) {
            return $this;
        }

        $this->userdata = $this->sessionService->$name;

        return $this->userdata;
    }

    public function session() {

        return $this->sessionService;
    }

}
