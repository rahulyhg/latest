<?php

namespace Admin\Service\Factory;

use Admin\Service\BranchService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BranchServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new BranchService(
                $serviceLocator->get('Admin\Mapper\BranchMapperInterface')
        );
    }

}
