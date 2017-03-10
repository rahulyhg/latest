<?php

namespace Admin\Controller\Factory;

use Admin\Controller\CommunityController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommunityControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $communityService = $realServiceLocator->get('Admin\Service\CommunityServiceInterface');

        return new CommunityController($commonService, $adminService, $communityService);
    }

}
