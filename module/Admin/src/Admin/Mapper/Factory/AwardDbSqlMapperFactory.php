<?php

namespace Admin\Mapper\Factory;

use Admin\Mapper\AwardDbSqlMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AwardDbSqlMapperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new AwardDbSqlMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
