<?php

namespace Application\Service\Factory;

use Application\Service\MembershipService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MembershipServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new MembershipService(
                $serviceLocator->get('Application\Mapper\MembershipMapperInterface'),
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
