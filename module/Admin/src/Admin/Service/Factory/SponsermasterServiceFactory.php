<?php

namespace Admin\Service\Factory;

use Admin\Service\SponsermasterService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SponsermasterServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new SponsermasterService(
                $serviceLocator->get('Admin\Mapper\SponsermasterMapperInterface')
        );
    }

}
