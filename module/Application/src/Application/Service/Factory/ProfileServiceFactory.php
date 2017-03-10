<?php

namespace Application\Service\Factory;

use Application\Service\ProfileService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProfileServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new ProfileService(
                $serviceLocator->get('Application\Mapper\ProfileMapperInterface')
        );
    }

}
