<?php

namespace WebServices\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use WebServices\Service\LoginServices;
use WebServices\Service\CommonServicesInterface;
class LoginServicesFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
        //$parentLocator = $serviceLocator->getServiceLocator();
        $dbAdapter= $serviceLocator->get(Adapter::class);
        $commonService=$serviceLocator->get(CommonServicesInterface::class);
        return  new LoginServices($dbAdapter,$commonService);
    }

}

