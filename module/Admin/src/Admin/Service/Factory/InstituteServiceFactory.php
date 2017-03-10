<?php

namespace Admin\Service\Factory;

use Admin\Service\InstituteService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InstituteServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new InstituteService(
                $serviceLocator->get('Admin\Mapper\InstituteMapperInterface')
        );
    }

}
