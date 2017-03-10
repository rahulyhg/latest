<?php

namespace Admin\Service\Factory;

use Admin\Service\SponsertypeService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SponsertypeServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new SponsertypeService(
                $serviceLocator->get('Admin\Mapper\SponsertypeMapperInterface')
        );
    }

}
