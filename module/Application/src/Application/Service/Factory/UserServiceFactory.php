<?php

namespace Application\Service\Factory;

use Application\Service\UserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new UserService(
                $serviceLocator->get('Zend\Db\Adapter\Adapter'),
                $serviceLocator->get('Application\Mapper\UserMapperInterface')
        );
    }

}
