<?php

namespace WebServices\Controller\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WebServices\Service\CommonServicesInterface;
use WebServices\Service\LoginServicesInterface;
use WebServices\Service\UserServicesInterface;
use WebServices\Controller\UserServicesController;

class UserServicesControllerFactory implements FactoryInterface{
    
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $parentLocator = $serviceLocator->getServiceLocator();//die('ght');
        $commonServices= $parentLocator->get(CommonServicesInterface::class);
        $loginServices= $parentLocator->get(LoginServicesInterface::class);
        $userServices=$parentLocator->get(UserServicesInterface::class);
        return new UserServicesController($commonServices,$loginServices,$userServices);
    }

}
