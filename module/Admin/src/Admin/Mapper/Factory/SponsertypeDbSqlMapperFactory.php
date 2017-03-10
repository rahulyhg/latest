<?php

namespace Admin\Mapper\Factory;

use Admin\Mapper\SponsertypeDbSqlMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SponsertypeDbSqlMapperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new SponsertypeDbSqlMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
