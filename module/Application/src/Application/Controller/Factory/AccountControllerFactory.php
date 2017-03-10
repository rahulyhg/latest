<?php

 namespace Application\Controller\Factory;

use Application\Controller\AccountController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

 class AccountControllerFactory implements FactoryInterface
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
         $accountService        = $realServiceLocator->get('Application\Service\AccountServiceInterface');
         $userService        = $realServiceLocator->get('Application\Service\UserServiceInterface');
         $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');

         return new AccountController($accountService, $userService, $commonService);
     }
 }