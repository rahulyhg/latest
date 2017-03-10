<?php

namespace Admin\Service\Factory;

use Admin\Service\SubeventsService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubeventsServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new SubeventsService(
                $serviceLocator->get('Admin\Mapper\SubeventsMapperInterface')
        );
    }

}
