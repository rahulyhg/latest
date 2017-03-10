<?php

namespace Admin\Service\Factory;

use Admin\Service\EventmasterService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventmasterServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EventmasterService(
                $serviceLocator->get('Admin\Mapper\EventmasterMapperInterface')
        );
    }

}
