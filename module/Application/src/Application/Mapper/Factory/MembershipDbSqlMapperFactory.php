<?php
 namespace Application\Mapper\Factory;

use Application\Mapper\MembershipDbSqlMapper;
use Application\Model\Entity\Membership;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

 class MembershipDbSqlMapperFactory implements FactoryInterface
 {
     /**
      * Create service
      *
      * @param ServiceLocatorInterface $serviceLocator
      *
      * @return mixed
      */
     public function createService(ServiceLocatorInterface $serviceLocator)
     {
         return new MembershipDbSqlMapper(
             $serviceLocator->get('Zend\Db\Adapter\Adapter'),
             new ClassMethods(false),
             new Membership()
         );
     }
 }