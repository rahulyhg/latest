<?php

namespace Application\SessionServices;

class SessionService {

    public $sessionContainer;

    public function setSessionContainer($sessionContainer) {
        $this->sessionContainer = $sessionContainer;
    }

    public function __invoke() {
        return $this->sessionContainer;
    }

}
