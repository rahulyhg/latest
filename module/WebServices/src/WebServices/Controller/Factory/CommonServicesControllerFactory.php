<?php

namespace WebServices\Controller\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WebServices\Controller\CommonServicesController;
class CommonServicesControllerFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator){
          
            $realServiceLocator = $serviceLocator->getServiceLocator();
            $commonServices=$realServiceLocator->get('WebServices\Service\CommonServicesInterface');            
            return new CommonServicesController($commonServices);
        
    }

}
