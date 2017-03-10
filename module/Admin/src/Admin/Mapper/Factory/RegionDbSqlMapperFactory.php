<?php

namespace Admin\Mapper\Factory;

use Admin\Mapper\RegionDbSqlMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegionDbSqlMapperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new RegionDbSqlMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
