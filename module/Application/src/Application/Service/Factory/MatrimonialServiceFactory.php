<?php

namespace Application\Service\Factory;

use Application\Service\MatrimonialService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MatrimonialServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        return new MatrimonialService(
                $serviceLocator->get('Application\Mapper\MatrimonialMapperInterface'),
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
