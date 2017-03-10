<?php

namespace Admin\Mapper\Factory;

use Admin\Mapper\UsertypemasterDbSqlMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsertypemasterDbSqlMapperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new UsertypemasterDbSqlMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
