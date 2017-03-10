<?php

namespace Admin\Controller\Factory;

use Admin\Controller\SubcommunityController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubcommunityControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $subcommunityService = $realServiceLocator->get('Admin\Service\SubcommunityServiceInterface');

        return new SubcommunityController($commonService, $adminService, $subcommunityService);
    }

}
