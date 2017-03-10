<?php

 namespace Application\Mapper\Factory;

use Application\Mapper\AccountDbSqlMapper;
use Application\Model\Entity\Account;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class AccountDbSqlMapperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new AccountDbSqlMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter'), new ClassMethods(), new Account()
        );
    }

}
