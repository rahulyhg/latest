<?php
 namespace Common\Service\Factory;

 use Common\Service\PostService;
 use Zend\ServiceManager\FactoryInterface;
 use Zend\ServiceManager\ServiceLocatorInterface;

 class PostServiceFactory implements FactoryInterface
 {
     /**
      * Create service
      *
      * @param ServiceLocatorInterface $serviceLocator
      * @return mixed
      */
     public function createService(ServiceLocatorInterface $serviceLocator)
     {
         return new PostService(
             $serviceLocator->get('Common\Mapper\PostMapperInterface')
         );
     }
 }