<?php

namespace Common\Plugin;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class AuthFrontPlugin extends AbstractPlugin {

    public function getUser() {
        $auth = new AuthenticationService();
        $storage = $auth->getStorage();
        return $storage->read();
    }

    public function isLogin() {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity() && in_array($auth->getIdentity()->role, array('user'))) {
            return true;
        } else {
            return false;
        }
    }
    
    public function checkLogin() {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity() && in_array($auth->getIdentity()->role, array('user'))) {
            return true;
        } else {
            return false;
        }
    }

}
