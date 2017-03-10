<?php

namespace Common\Helper\Factory;

use Common\Helper\AuthFrontHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthFrontHelperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sessionService = $serviceLocator->getServiceLocator()->get('sessionService');
        return new AuthFrontHelper($sessionService());
    }

}
