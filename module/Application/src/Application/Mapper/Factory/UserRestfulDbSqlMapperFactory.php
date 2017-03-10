<?php

namespace Application\Mapper\Factory;

use Application\Mapper\UserRestfulDbSqlMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserRestfulDbSqlMapperFactory  implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) { 
        return new UserRestfulDbSqlMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}