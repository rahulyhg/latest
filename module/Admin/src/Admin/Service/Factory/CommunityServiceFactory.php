<?php

namespace Admin\Service\Factory;

use Admin\Service\CommunityService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommunityServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new CommunityService(
                $serviceLocator->get('Admin\Mapper\CommunityMapperInterface')
        );
    }

}
