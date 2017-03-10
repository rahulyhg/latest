<?php

 namespace Application\Controller\Factory;

use Application\Controller\PostsController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

 class PostsControllerFactory implements FactoryInterface
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
         $realServiceLocator = $serviceLocator->getServiceLocator();
          $profileService        = $realServiceLocator->get('Application\Service\ProfileServiceInterface');
        $userService = $realServiceLocator->get('Application\Service\UserServiceInterface');
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');

         return new PostsController($profileService, $commonService, $userService);
     }
 }