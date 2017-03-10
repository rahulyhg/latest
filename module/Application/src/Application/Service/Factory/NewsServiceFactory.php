<?php

namespace Application\Service\Factory;

use Application\Service\NewsService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NewsServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new NewsService(
                $serviceLocator->get('Application\Mapper\NewsMapperInterface')
        );
    }

}
