<?php

namespace Admin\Controller\Factory;

use Admin\Controller\SponsertypeController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SponsertypeControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $sponsertypeService = $realServiceLocator->get('Admin\Service\SponsertypeServiceInterface');

        return new SponsertypeController($commonService, $adminService, $sponsertypeService);
    }

}
