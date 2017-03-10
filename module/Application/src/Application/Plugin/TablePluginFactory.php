<?php

namespace Application\Plugin;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Application\Plugin\TablePlugin;

class TablePluginFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        return new TablePlugin(
                $sm->get('Zend\Db\Adapter\Adapter')
                );
    }

}
