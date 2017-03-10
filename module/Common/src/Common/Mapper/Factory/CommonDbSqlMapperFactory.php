<?php

namespace Common\Mapper\Factory;

use Common\Mapper\CommonDbSqlMapper;
use Common\Model\Entity\Common;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class CommonDbSqlMapperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new CommonDbSqlMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter'), new ClassMethods(), new Common()
        );
    }

}
