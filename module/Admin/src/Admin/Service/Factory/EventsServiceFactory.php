<?php

namespace Admin\Service\Factory;

use Admin\Service\EventsService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventsServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EventsService(
                $serviceLocator->get('Admin\Mapper\EventsMapperInterface')
        );
    }

}
