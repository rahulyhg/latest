<?php

namespace Common\Helper\Factory;

use Common\Helper\UserSessionHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserSessionHelperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sessionService = $serviceLocator->getServiceLocator()->get('sessionService');
        return new UserSessionHelper($sessionService());
    }

}
