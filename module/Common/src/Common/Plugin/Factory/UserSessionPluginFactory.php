<?php

namespace Common\Plugin\Factory;

use Common\Plugin\UserSessionPlugin;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserSessionPluginFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sessionService = $serviceLocator->getServiceLocator()->get('sessionService');
        return new UserSessionPlugin($sessionService());
    }

}
