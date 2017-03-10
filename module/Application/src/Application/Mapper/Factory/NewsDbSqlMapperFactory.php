<?php
 namespace Application\Mapper\Factory;

use Application\Mapper\NewsDbSqlMapper;
use Application\Model\Entity\News;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

 class NewsDbSqlMapperFactory implements FactoryInterface
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
         return new NewsDbSqlMapper(
             $serviceLocator->get('Zend\Db\Adapter\Adapter'),
             new ClassMethods(false),
             new News()
         );
     }
 }