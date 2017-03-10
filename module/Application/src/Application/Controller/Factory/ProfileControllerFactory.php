<?php

namespace Application\Controller\Factory;

use Application\Controller\ProfileController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProfileControllerFactory implements FactoryInterface {


    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $profileService        = $realServiceLocator->get('Application\Service\ProfileServiceInterface');
        $userService = $realServiceLocator->get('Application\Service\UserServiceInterface');
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');

        return new ProfileController($profileService, $commonService, $userService);
    }

}
