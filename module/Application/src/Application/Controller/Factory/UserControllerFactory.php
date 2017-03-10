<?php

namespace Application\Controller\Factory;

use Application\Controller\UserController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserControllerFactory implements FactoryInterface {


    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $userService = $realServiceLocator->get('Application\Service\UserServiceInterface');
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');

        return new UserController($commonService, $userService);
    }

}
