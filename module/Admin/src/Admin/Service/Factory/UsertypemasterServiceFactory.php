<?php

namespace Admin\Service\Factory;

use Admin\Service\UsertypemasterService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsertypemasterServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new UsertypemasterService(
                $serviceLocator->get('Admin\Mapper\UsertypemasterMapperInterface')
        );
    }

}
