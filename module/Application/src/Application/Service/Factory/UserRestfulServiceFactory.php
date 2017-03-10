<?php

namespace Application\Service\Factory;

use Application\Service\UserRestfulService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserRestfulServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        return new UserRestfulService(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
