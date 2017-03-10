<?php

namespace Common\Plugin\Factory;

use Common\Plugin\TablePlugin;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TablePluginFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sessionService = $serviceLocator->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        return new TablePlugin($sessionService);
    }

}
