<?php

namespace Common\Plugin\Factory;

use Common\Plugin\MyPlugin;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MyPluginFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sessionService = $serviceLocator->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        return new MyPlugin($sessionService);
    }

}
