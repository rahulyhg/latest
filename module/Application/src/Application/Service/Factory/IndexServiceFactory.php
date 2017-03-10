<?php

namespace Application\Service\Factory;

use Application\Service\IndexService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new IndexService(
                $serviceLocator->get('Application\Mapper\IndexMapperInterface')
        );
    }

}
