<?php

namespace Admin\Service\Factory;

use Admin\Service\NewsService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NewsServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new NewsService(
                $serviceLocator->get('Admin\Mapper\NewsMapperInterface')
        );
    }

}
