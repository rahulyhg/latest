<?php

namespace Admin\Service\Factory;

use Admin\Service\MembershipfeatureService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MembershipfeatureServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new MembershipfeatureService(
                $serviceLocator->get('Admin\Mapper\MembershipfeatureMapperInterface')
        );
    }

}
