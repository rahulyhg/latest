<?php

namespace Admin\Service\Factory;

use Admin\Service\AwardService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AwardServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new AwardService(
                $serviceLocator->get('Admin\Mapper\AwardMapperInterface')
        );
    }

}
