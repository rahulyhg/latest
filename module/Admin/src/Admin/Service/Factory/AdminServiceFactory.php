<?php

namespace Admin\Service\Factory;

use Admin\Service\AdminService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new AdminService(
                $serviceLocator->get('Admin\Mapper\AdminMapperInterface'),
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
