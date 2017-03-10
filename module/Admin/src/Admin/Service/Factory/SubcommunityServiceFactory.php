<?php

namespace Admin\Service\Factory;

use Admin\Service\SubcommunityService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubcommunityServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new SubcommunityService(
                $serviceLocator->get('Admin\Mapper\SubcommunityMapperInterface')
        );
    }

}
