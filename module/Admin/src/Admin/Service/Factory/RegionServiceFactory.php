<?php

namespace Admin\Service\Factory;

use Admin\Service\RegionService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegionServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new RegionService(
                $serviceLocator->get('Admin\Mapper\RegionMapperInterface')
        );
    }

}
