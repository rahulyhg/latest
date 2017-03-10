<?php

namespace WebServices\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WebServices\Service\CommonServicesInterface;
use WebServices\Service\LoginServicesInterface;
use WebServices\Service\UserServicesInterface;
use Zend\Db\Adapter\Adapter;
use WebServices\Service\ImageServices;
use WebServices\Service\UserServices;

class UserServicesFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $dbAdapter= $serviceLocator->get(Adapter::class); 
        $commonService=$serviceLocator->get(CommonServicesInterface::class);
        $loginService=$serviceLocator->get(LoginServicesInterface::class);
        //$userService=$serviceLocator->get(UserServicesInterface::class);
        return  new UserServices($dbAdapter,$commonService,$loginService);    
    }

}


