<?php

namespace WebServices\Service\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WebServices\Service\CommonServicesInterface;
use WebServices\Service\LoginServicesInterface;
use WebServices\Service\UserServicesInterface;
use WebServices\Service\ImageServices;
use Zend\Db\Adapter\Adapter;

class ImageServicesFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $dbAdapter= $serviceLocator->get(Adapter::class); 
        $commonService=$serviceLocator->get(CommonServicesInterface::class);
        $loginService=$serviceLocator->get(LoginServicesInterface::class);
        $userService=$serviceLocator->get(UserServicesInterface::class);
        return new ImageServices($dbAdapter, $commonService, $loginService, $userService);
        
    }

}

