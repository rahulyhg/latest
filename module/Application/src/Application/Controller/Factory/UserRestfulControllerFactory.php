<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Controller\Factory;
use Application\Controller\UserRestfulController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserRestfulControllerFactory implements FactoryInterface {


    public function createService(ServiceLocatorInterface $serviceLocator) {
       
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $userService = $realServiceLocator->get('Application\Service\UserServiceInterface');
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $userRestfulService = $realServiceLocator->get('Application\Service\UserRestfulServiceInterface');
        return  new UserRestfulController($commonService, $userService, $userRestfulService);       

    }

  

}
