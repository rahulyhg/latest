<?php

namespace Admin\Controller\Factory;

use Admin\Controller\RegionController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegionControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $regionService = $realServiceLocator->get('Admin\Service\RegionServiceInterface');

        return new RegionController($commonService, $adminService, $regionService);
    }

}
