<?php

namespace Admin\Mapper\Factory;

use Admin\Mapper\EventmasterDbSqlMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventmasterDbSqlMapperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new EventmasterDbSqlMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
