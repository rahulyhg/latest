<?php
namespace WebServices\Service\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WebServices\Service\CommonServices;
class CommonServicesFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
            
       // $realServiceLocator= $serviceLocator->getServiceLocator();
       return new CommonServices($serviceLocator->get('Zend\Db\Adapter\Adapter'));
        
        
    }

}

