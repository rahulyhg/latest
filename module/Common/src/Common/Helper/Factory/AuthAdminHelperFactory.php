<?php

namespace Common\Helper\Factory;

use Common\Helper\AuthAdminHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthAdminHelperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sessionService = $serviceLocator->getServiceLocator()->get('sessionService');
        return new AuthAdminHelper($sessionService());
    }

}
