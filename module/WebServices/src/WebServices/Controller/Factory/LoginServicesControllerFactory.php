<?php

namespace WebServices\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WebServices\Controller\LoginServicesController;
use WebServices\Service\LoginServicesInterface;
use WebServices\Service\CommonServicesInterface;

class LoginServicesControllerFactory implements FactoryInterface{
    
    
    public function createService(ServiceLocatorInterface $serviceLocator) { //die('fd');
        $parentLocator = $serviceLocator->getServiceLocator();//die('ght');
        $commonServices= $parentLocator->get(CommonServicesInterface::class);//die('ght');
        $loginServices= $parentLocator->get(LoginServicesInterface::class);
        return new LoginServicesController($commonServices,$loginServices);
        
        
        
    }

}

