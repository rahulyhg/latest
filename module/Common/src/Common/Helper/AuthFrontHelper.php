<?php

namespace Common\Helper;

use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

class AuthFrontHelper extends AbstractHelper {

    public function getUser() {
        $auth = new AuthenticationService();
        $storage = $auth->getStorage();
        return $storage->read();
    }

    public function isLogin() {
        $auth = new AuthenticationService();
        if ($auth->getIdentity() && in_array($auth->getIdentity()->role, array('user'))) {
            return true;
        } else {
            return false;
        }
    }
    
    public function checkLogin() {
        $auth = new AuthenticationService();
        if ($auth->getIdentity() && in_array($auth->getIdentity()->role, array('user'))) {
            return true;
        } else {
            return false;
        }
    }

}
