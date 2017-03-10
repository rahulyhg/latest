<?php

namespace Common\Plugin\Factory;

use Common\Plugin\AuthFrontPlugin;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthFrontPluginFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sessionService = $serviceLocator->getServiceLocator()->get('sessionService');
        return new AuthFrontPlugin($sessionService());
    }

}
