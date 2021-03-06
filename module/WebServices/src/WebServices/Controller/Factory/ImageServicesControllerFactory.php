<?php

namespace WebServices\Controller\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WebServices\Service\CommonServicesInterface;
use WebServices\Service\LoginServicesInterface;
use WebServices\Service\UserServicesInterface;
use WebServices\Controller\ImageServicesController;
use WebServices\Service\ImageServicesInterface;

class ImageServicesControllerFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $parentLocator = $serviceLocator->getServiceLocator();
        $commonServices= $parentLocator->get(CommonServicesInterface::class);
        $loginServices= $parentLocator->get(LoginServicesInterface::class);
        $userServices=$parentLocator->get(UserServicesInterface::class);
        $imageServices=$parentLocator->get(ImageServicesInterface::class);// die('ght');
        return new ImageServicesController($commonServices,$loginServices,$userServices, $imageServices);    
    }

}

